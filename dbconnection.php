<?php
require 'vendor/autoload.php';

// Using Medoo namespace
use Medoo\Medoo;



function dbConnect(){
    /*$db = new mysqli($HOST,$USER,$PWD,$NAME,$PORT);
    /* check connection 
    if ($db->connect_errno) {
        printf("Connect failed: %s\n", $db->connect_error);
        exit();
    }

    /* check if server is alive 
    if ($db->ping()) {
        printf ("Our connection is ok!\n");
        return $db;
    } else {
        printf ("Error: %s\n", $mysqli->error);
        return;
    }*/

    // Initialize
     return $database = new Medoo([
    'database_type' => 'mysql',
    'database_name' => constant("DB_NAME"),
    'server' => constant("DB_HOST"),
    'username' => constant("DB_USER"),
    'password' => constant("DB_PWD"),
    'charset' => 'utf8',
    ]);
        
}



function dbInsertWPRESTAPI($tblname,$data,$db,$dataType=1){
   /*$query = "INSERT INTO  ". $tblname ."(title,content,pubdate,link,destimg) VALUES('" . 
                $data[0] ."','" .
                $data[1] ."','" .
                $data[3] ."','" .
                $data[4] ."','" .
                $data[5] ."')" ;
            
   // $query = "INSERT INTO  ". $tblname ."(pubdate) VALUES('" . $data[2] . "')" ;
    return (mysqli_query($db, $query));    */

    switch($dataType){
        case 1:
            $db->insert($tblname, [
                'title' => $data[0],
                'content' => $data[2],
                'excerpt' => $data[1],
                'pubdate' => $data[3],
                'link' => $data[4],
                'destimg' => $data[5],
                'imgs' => $data[6],
                'postdata[JSON]' => $data[7]
            ]);
        break;

        case 2:

            $db->insert($tblname, [
                'id' => $data[0],
                'data[JSON]' => $data[1]
            ]);
        break;

    }
    
}

function dbInsertXML($tblname,$data,$db){
    /*$query = "INSERT INTO  ". $tblname ."(title,content,pubdate,link,destimg) VALUES('" . 
                 $data[0] ."','" .
                 $data[1] ."','" .
                 $data[3] ."','" .
                 $data[4] ."','" .
                 $data[5] ."')" ;
             
    // $query = "INSERT INTO  ". $tblname ."(pubdate) VALUES('" . $data[2] . "')" ;
     return (mysqli_query($db, $query));    */
 
 
     $db->insert($tblname, [
         'title' => $data[0],
         'content' => $data[1],
         'pubdate' => $data[2],
         'link' => $data[3],
         'destimg' => $data[4]
         
     ]);
 }




function dbSelect($table,$db,$dataType=1){
     switch($dataType){
         case 1:
            return $db->select($table, 'title');
         break;
         case 2:
            return $db->select($table, 'id');
         break;
         case 3:
            return $db->select($table, 'data[JSON]');
         break;

     }
}



