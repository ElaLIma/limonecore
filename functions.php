<?php
function catAndTagsToFB($ids,$tblname,$db,$firebase,$type=1){

    $rIds = json_decode(dBSelect($tblname,$db,3),true);

    foreach ($ids as $id) {
        $idToFireBase = true;
        foreach($rIds as $rid){
            // print($rid[0]);
            if($rid['id'] == $id ){
                $idToFireBase = false;
            }

            if($idToFireBase){
                $catToFBElement = array(
                    "id" => $id,
                    "name" => $rid['name']
                );
                switch($type){
                    case 1:
                         $firebase->set(constant('CATEGORIES_PATH') . '/' . $id, $catToFBElement);
                    break;
                    case 2:
                        $firebase->set(constant('TAGS_PATH') . '/' . $id, $catToFBElement);
                    break;

                }
                

            }
        }
    }

}


function jsonPostData2DB($site, $data,$tblname,$db,$firebase) {
    
    $send2DB = true;
    $retrievedTitles = dbSelect($tblname,$db);
    foreach($data as $json){
        $title = fetchWpRestApiNewsTitle($json);
        foreach($retrievedTitles as $rTitle){
            // print($rTitle . "\n");
            if($rTitle == $title){
                $send2DB = false;
                break;
            }
        }
        if($send2DB){
            if($json['type'] == "post"){
                if($json["status"] == "publish"){
                   //  print("New post in " . $site["name"] . "---------****\n");
                    $link = fetchWpRestApiNewsLink($json);
                    $id = fetchWpRestApiPostId($json);
                    $author = fetchWpRestApiPostAuthor($json);
                    $catids = fetchWpRestApiPostCatIds($json);
                    $tagids = fetchWpRestApiPostTagsIds($json); 
                    $content = fetchWpRestApiNewsContent($json);
                    $content = iconv(mb_detect_encoding($content, mb_detect_order(), 'strict'), "UTF-8", $content);
                    $pubDate = fetchWpRestApiNewsPubDate($json);
                    // $pubDate = DateTime::createFromFormat(DATE_W3C, $pubDate);
                    // print($pubDate);
                    $imgs = fetchWpRestApiNewsImgsDetails(fetchWpRestApiNewsImgs($json));
                    $postdata = $json;
                    $destimg = fetchWpRestApiNewsDestImg(fetchWpRestApiNewsImgs($json));
                    $excerpt = fetchWpRestApiNewsExcerpt($json);
                    $excerpt = iconv(mb_detect_encoding($excerpt, mb_detect_order(), 'strict'), "UTF-8", $excerpt);

                    

                    $postToFB = array(
                        "title" => $title,
                        "destimg" => $destimg,
                        "author" => $author,
                        "content" => $content,
                        "link" => $link,
                        "tags" => $tagids,
                        "categories" => $catids
                    );


                    // Data to Firebase
                    $firebase->set(constant('POSTS_PATH') . '/' . $id, $postToFB);
                    $firebase->set(constant('IMGS_PATH') . '/' . $id, $imgs);
                    $firebase->set(constant('EXCERPTS_PATH') . '/' . $id, $excerpt);
                    $firebase->set(constant('CONTENTS_PATH') . '/' . $id, $content);
                    
                    $dbdata = array($title,$excerpt,$content,$pubDate,$link,$destimg,$imgs,$postdata); 
                    dbInsertWPRESTAPI($tblname,$dbdata,$db);
                }
            }
            
        }

    }

}


function jsonCatTagData2DB($site, $data,$tblname,$db,$firebase,$cat=true) {
    
    $dataType = 2;
    $retrievedIds = dbSelect($tblname,$db,$dataType);

    foreach($data as $json){
        $send2DB = true;
        if(count($retrievedIds) == 0){
                        $catData = $data[0];
                        $catToFBElement = array(
                            "id" => $data[0]['id'],
                            "name" => $data[0]['name']
                        );
                        $dbdata = array($data[0]['id'],$catData);

                        if($cat){
                            $firebase->set(constant('CATEGORIES_PATH') . '/' . $data[0]["id"], $catToFBElement);

                        }else{
                            $firebase->set(constant('TAGS_PATH') . '/' . $data[0]["id"], $catToFBElement);
                        }
                        
                        dbInsertWPRESTAPI($tblname,$dbdata,$db,$dataType);

        }elseif(count($retrievedIds) > 0){
            
            foreach ($retrievedIds as $rId) {
                if($json['id'] == $rId){
                    $send2DB = false;
                }
    
                if($send2DB){
                    $catData = $json;
                    $catToFBElement = array(
                        "id" => $json['id'],
                        "name" => $json['name']
                    );
                    $dbdata = array($json['id'],$catData); 
                    if($cat){
                        $firebase->set(constant('CATEGORIES_PATH') . '/' . $json['id'], $catToFBElement);
                    }else{
                        $firebase->set(constant('TAGS_PATH') . '/' . $json['id'], $catToFBElement);
                    }
                    
                    dbInsertWPRESTAPI($tblname,$dbdata,$db,$dataType);
                }
            }

        }
    
        
    }
    
    
}

