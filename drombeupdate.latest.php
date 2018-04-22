#!/usr/bin/php
<?php
include ('inc.php');

$db = dbConnect();
$jsonData = array();

foreach ($sites as $site){
    if ($site["site-code"] == "dr"){

        $tblname = $site["tblname"] ; 
        $firebaseURL = $site["firebase-default-url"];
        $firebaseToken = $site["firebase-default-token"];

        // PostData
        $jsonPostURL = $site["url"] . $site["datapath"];
        $jsonPostURL = $jsonPostURL . '?per_page=10';
        $jsonPostData = jsonData(httpRQ($jsonPostURL));
        $firebase = new \Firebase\FirebaseLib($firebaseURL, $firebaseToken);

        jsonPostData2DB($site,$jsonPostData,$tblname, $db,$firebase);
    }
}
          




