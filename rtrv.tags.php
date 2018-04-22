<?php 

//Habilitar CORS
/*if (isset($_SERVER['HTTP_ORIGIN'])) {  
    header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");  
    header('Access-Control-Allow-Credentials: true');  
    header('Access-Control-Max-Age: 86400');   
}  
  
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {  
  
    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))  
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");  
  
    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))  
        header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");  
} */



$target = $_GET['target'] . ".tags";


define("DB_HOST","localhost");
define("DB_PORT",2082);
define("DB_USER", "berigayo_testusr");
define("DB_PWD","01234");
define("DB_NAME","berigayo_test");



// If you installed via composer, just use this code to requrie autoloader on the top of your projects.
require 'vendor/autoload.php';
 
// Using Medoo namespace
use Medoo\Medoo;
 
// Initialize
$database = new Medoo([
    'database_type' => 'mysql',
    'database_name' => constant("DB_NAME"),
    'server' => constant("DB_HOST"),
    'username' => constant("DB_USER"),
    'password' => constant("DB_PWD"),
    'charset' => 'utf8',
]);


$data = $database->select($target, '*');
 
echo json_encode($data);