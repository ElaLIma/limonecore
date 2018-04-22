#!/usr/bin/php
<?php
include ('inc.php');

$db = dbConnect();
$jsonData = array();

foreach ($sites as $site){
    if ($site["site-code"] == "rmacuto"){
        $firebaseURL = $site["firebase-default-url"];
        $firebaseToken = $site["firebase-default-token"];
        $catTblname = $site["catTblname"] ; 
        $jsonCatURL = $site["url"] . $site["catpath"];
        $jsonCatURL = $jsonCatURL . '?per_page=100';
        $jsonCatData = jsonData(httpRQ($jsonCatURL));
        $firebase = new \Firebase\FirebaseLib($firebaseURL, $firebaseToken);
        jsonCatTagData2DB($site,$jsonCatData,$catTblname, $db,$firebase);
    }
}
          
