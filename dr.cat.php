#!/usr/bin/php
<?php
include ('inc.php');

$db = dbConnect();
$jsonData = array();

foreach ($sites as $site){
    if ($site["site-code"] == "dr"){

        $catTblname = $site["catTblname"] ; 
        $firebaseURL = $site["firebase-default-url"];
        $firebaseToken = $site["firebase-default-token"];
        $jsonURL = $site["url"] . $site["catpath"];
        $jsonURL = $jsonURL . '?per_page=100';
        $jsonData = jsonData(httpRQ($jsonURL));
        $firebase = new \Firebase\FirebaseLib($firebaseURL, $firebaseToken);
        jsonCatTagData2DB($site,$jsonData,$catTblname,$db,$firebase);
    }
}
          

function jsonData2DB($site, $data,$tblname,$db) {
    $send2DB = true;
    $dataType = 2;
    $retrievedId = dbSelectTitles($tblname,$db,$dataType);
    foreach($data as $json){
        $catId = fetchWpRestApiCatId($json);
        // print($catId . "\n");
        foreach($retrievedId as $rId){
            if($rId == $catId){
                $send2DB = false;
            }
        }
        if($send2DB){
                    $catData = $json;
                    print_r($json);
                    $dbdata = array($catId,$catData); 
                    dbInsertWPRESTAPI($tblname,$dbdata,$db,$dataType);
            
        }
    }
}


