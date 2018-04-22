#!/usr/bin/php
<?php
include ('inc.php');

$db = dbConnect();
$jsonData = array();

foreach ($sites as $site){
    if ($site["fetchType"] == "wprestapi"){

        $tblname = $site["tblname"] ; 
        $jsonURL = $site["url"] . $site["datapath"];
        $page = 0;

        do{
            $page++;
            $jsonURL = $jsonURL . '?per_page=50&page='.$page;
            $jsonData = jsonData(httpRQ($jsonURL));
            jsonData2DB($site,$jsonData,$tblname, $db);

        }while(count($jsonData) != 0);

        // print(count($jsonData));
    }
}
          

function jsonData2DB($site, $data,$tblname,$db) {
    $send2DB = true;
    $retrievedTitles = dbSelectTitles($tblname,$db);
    foreach($data as $json){
        $title = fetchWpRestApiNewsTitle($json);
        foreach($retrievedTitles as $rTitle){
            if($rTitle == $title){
                $send2DB = false;
            }
        }
        if($send2DB){
            if($json['type'] == "post"){
                if($json["status"] == "publish"){
                    print("New post in " . $site["name"] . "---------****\n");
                    $link = fetchWpRestApiNewsLink($json);
                    $content = fetchWpRestApiNewsContent($json);
                    $content = iconv(mb_detect_encoding($content, mb_detect_order(), 'strict'), "UTF-8", $content);
                    $pubDate = fetchWpRestApiNewsPubDate($json);
                    // $pubDate = DateTime::createFromFormat(DATE_W3C, $pubDate);
                    // print($pubDate);
                    $destimg = fetchWpRestApiNewsDestImg(fetchWpRestApiNewsImgs($json));
                    $excerpt = fetchWpRestApiNewsExcerpt($json);
                    $excerpt = iconv(mb_detect_encoding($excerpt, mb_detect_order(), 'strict'), "UTF-8", $excerpt);
                    $dbdata = array($title,$excerpt,$content,$pubDate,$link,$destimg); 
                    dbInsertWPRESTAPI($tblname,$dbdata,$db);
                }
            }
            
        }

    }

}


