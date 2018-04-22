<?php 
// include ('inc.php');
// $db = dbConnect();
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



$target = $_GET['target'];
// $target = "dr";


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

$hoy = new DateTime("NOW");
$haceUnaSemana = mktime(0,0,0,$hoy->format('m'),$hoy->format('d')-7,$hoy->format('Y'));
// print("Hoy es:" . $hoy->format('Y-m-d G:i:s') . "\n");
// print("Hace una semana fue:" . date('Y-m-d G:i:s', $haceUnaSemana). "\n");
$data = $database->select($target, '*',[
    'LIMIT' => 20,
    // 'pubdate[<>]' => [date("Y-m-d", mktime(0,0,0,$hoy->format('m'),$hoy->format('d')-8,$hoy->format('Y'))),date("Y-m-d", mktime(0, 0, 0, $hoy->format('m'), $hoy->format('d')+1, $hoy->format('Y')))]
    'pubdate[<]' => date("Y-m-d", mktime(0, 0, 0, $hoy->format('m'), $hoy->format('d')+1, $hoy->format('Y')))
]);
// $data = $db->select($target, 'pubdate');
/* foreach ($data as $key) {
    $da = new DateTime($key['pubdate']);
    $interval = $da->diff($hoy);
    echo $interval->format('%d' . " \n");
    echo $key['title'] . "\n";
    echo $key['pubdate'] . "\n";
}*/
 echo json_encode($data);