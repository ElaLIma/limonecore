#!/usr/bin/php
<?php
include ('inc.php');

$db = dbConnect();


foreach ($sites as $site){
    if($site["fetchType"] == "rss1-2"){
        // print("\n".$site["name"]);
        // Obtaining data
        $tblname = $site["tblname"] ; 
        $xmlurl = $site["url"] . $site["datapath"];
        $firebaseURL = $site["firebase-default-url"];
        $firebaseToken = $site["firebase-default-token"]; 
        $firebase = new \Firebase\FirebaseLib($firebaseURL, $firebaseToken);
        $xmldata = httpRQ($xmlurl);
        $xml = simplexml_load_string($xmldata);
        $retrievedTitles = dbSelect($tblname,$db);
        $send2DB = true;
        switch($site["site-code"]){
            case 'asdg2':
            case 'lgc':{
                $rss = new DOMDocument();
                $rss->load($xmlurl);
                $feed = array();
                foreach ($rss->getElementsByTagName('item') as $node) {
                            $title = $node->getElementsByTagName('title')->item(0)->nodeValue;
                            foreach($retrievedTitles as $rTitle){
                                if($rTitle == $title){
                                    $send2DB = false;
                                }
                            }
                            if($send2DB){
                                $link = $node->getElementsByTagName('link')->item(0)->nodeValue;
                                $pubDate = $node->getElementsByTagName('pubDate')->item(0)->nodeValue;
                                $pubDate = DateTime::createFromFormat('Y-m-d G:i:s',DateTime::createFromFormat('D, d M Y H:i:s T', $pubDate)->format(DATE_W3C));
                                // print($pubDate);
                                $description = $node->getElementsByTagName('description')->item(0)->nodeValue;
                                $content = $node->getElementsByTagName('encoded')->item(0)->nodeValue;
                                $content = iconv(mb_detect_encoding($content, mb_detect_order(), true), "UTF-8", $content);
                                if($site["site-code"] == "lgc"){
                                    $destimg = explode("\"",$content)[1];

                                }else{
                                    $destimg = "http://www.asodeguesegundaetapa.org/wp-content/themes/asodegueseg/images/header/Asodegue-logo-cabecera.png";
                                }
                                $dbdata = array($title,$content,$pubDate,$link,$destimg); 
                                $id = hash(hash_algos()[24],$title,false);
                                print($id);
                                $postToFB = array(
                                    "title" => $title,
                                    "destimg" => $destimg,
                                    // "author" => $author,
                                    "content" => $content,
                                    "link" => $link,
                                    "pubdate" => $pubDate
                                    // "tags" => $tagids,
                                    // "categories" => $catids
                                );
                                // Data to Firebase
                                $firebase->set(constant('POSTS_PATH') . '/' . $id, $postToFB);
                                $firebase->set(constant('IMGS_PATH') . '/' . $id, $destimg);
                                // $firebase->set(constant('EXCERPTS_PATH') . '/' . $id, $excerpt);
                                $firebase->set(constant('CONTENTS_PATH') . '/' . $id, $content);
                                // print_r ($dbdata);
                                dbInsertXML($tblname,$dbdata,$db);

                            }
                }
            }
            break;
            case 'lov':{
                // echo($xml);
                // print($xmlurl . "\n");
                foreach($xml->channel->item as $itm){
                    $title =  fetchXmlNewsTitle($itm);
                    foreach($retrievedTitles as $rTitle){
                        if($rTitle == $title){
                            $send2DB = false;
                        }
                    }
                    if($send2DB){
                        $pubdate = fetchXmlNewsPubDate($itm);
                        // $pubdate = DateTime::createFromFormat('Y-m-d G:i:s',DateTime::createFromFormat('D, d M Y H:i:s T', $pubdate)->format(DATE_W3C));
                        $link = fetchXmlNewsLink($itm);
                        $destimg = fetchXmlNewsImg($itm);
                        $content = fetchXmlNewsExcerpt($itm);
                        $content = iconv(mb_detect_encoding($content, mb_detect_order(), true), "UTF-8", $content);
                        $dbdata = array($title,$content,$pubdate,$link,$destimg); 
                        $id = hash(hash_algos()[24],$title,false);
                                print($id);
                                $postToFB = array(
                                    "title" => $title,
                                    "destimg" => $destimg,
                                    // "author" => $author,
                                    "content" => $content,
                                    "link" => $link,
                                    "pubdate" => $pubdate
                                    // "tags" => $tagids,
                                    // "categories" => $catids
                                );
                        // Data to Firebase
                        $firebase->set(constant('POSTS_PATH') . '/' . $id, $postToFB);
                        $firebase->set(constant('IMGS_PATH') . '/' . $id, $destimg);
                        // $firebase->set(constant('EXCERPTS_PATH') . '/' . $id, $excerpt);
                        $firebase->set(constant('CONTENTS_PATH') . '/' . $id, $content);
                        dbInsertXML($tblname,$dbdata,$db);
                    }
                }
            }
            break;
            case 'gepress':{
                foreach($xml->channel->item as $itm){
                    $title =  fetchXmlNewsTitle($itm);
                    //print($title . "\n");
                    foreach($retrievedTitles as $rTitle){
                        if($rTitle == $title){
                            $send2DB = false;
                        }
                    }
                    if($send2DB){
                        $pubdate = fetchXmlNewsPubDate($itm);
                        // print($pubdate);
                        // $pubdate = DateTime::createFromFormat('Y-m-d G:i:s', $pubdate);
                        // $pubdate = DateTime::createFromFormat('Y-m-d G:i:s',DateTime::createFromFormat('D, d M Y H:i:s T', $pubdate)->format(DATE_W3C));
                        $link = fetchXmlNewsLink($itm);
                        $destimg = gePressNewsData($link,1);
                        $subheading = gePressNewsData($link,0);
                        $content = gePressNewsData($link,2);
                        $content = iconv(mb_detect_encoding($content, mb_detect_order(), true), "UTF-8", $content);
                        $dbdata = array($title,$content,$pubdate,$link,$destimg); 
                        $id = hash(hash_algos()[24],$title,false);
                        print($id);
                        $postToFB = array(
                            "title" => $title,
                            "destimg" => $destimg,
                            // "author" => $author,
                            "content" => $content,
                            "link" => $link,
                            "pubdate" => $pubdate
                            // "tags" => $tagids,
                            // "categories" => $catids
                        );
                        // Data to Firebase
                        $firebase->set(constant('POSTS_PATH') . '/' . $id, $postToFB);
                        $firebase->set(constant('IMGS_PATH') . '/' . $id, $destimg);
                        $firebase->set(constant('EXCERPTS_PATH') . '/' . $id, $subheading);
                        $firebase->set(constant('CONTENTS_PATH') . '/' . $id, $content);
                        dbInsertXML($tblname,$dbdata,$db);

                    }                  
                }               
            }
            break;
            default:
            break;

    }
        
    }
}



