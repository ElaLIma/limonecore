#!/usr/bin/php
<?php
include ('inc.php');

$db = dbConnect();
$jsonData = array();

foreach ($sites as $site){
    if ($site["site-code"] == "rmacuto"){
        $page = 1;
        do{
            $catTblname = $site["tagTblname"] ; 
            $firebaseURL = $site["firebase-default-url"];
            $firebaseToken = $site["firebase-default-token"];
            $jsonURL = $site["url"] . $site["tagpath"];
            $jsonURL = $jsonURL . '?per_page=100&page=' . $page;
            $jsonData = jsonData(httpRQ($jsonURL));
            $dataLenght = count($jsonData);
            $firebase = new \Firebase\FirebaseLib($firebaseURL, $firebaseToken);
            jsonCatTagData2DB($site,$jsonData,$catTblname, $db,$firebase,false);
            $page++;

        }while($dataLenght != 0);
       
    }
}
