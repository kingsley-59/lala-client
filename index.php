<?php

require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Src\System\DatabaseConnector;
use Src\Controller\Payments;
use Src\Controller\TxnListController;
//use Dotenv;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$dbConnection = (new DatabaseConnector)->getConnection();
$dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  //throw errors from all aspects of database connection

$controller = new Payments($dbConnection);

$mail = new PHPMailer(TRUE);

//echo $_ENV['OKTAAUDIENCE'];
header("Access-Control-Allow-Origin: *");
//header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode('/', $uri);

$includes = array();

//return home page is no uri parameter is given
if(!isset($uri[1]) || empty($uri[1])){
    $page = 'index';
    $file_path = __DIR__.'\includes\\' . $page. '.php';

    array_push($includes, $file_path);

    foreach($includes as $page){
        include $page;
    }

}

if(isset($uri[1]) && !empty($uri[1])){
    if($uri[1] == 'submit'){
        $data = file_get_contents('php://input');
        $data = json_decode($data);
        //echo "Data has been saved!";

        $result = $controller->save_order($data);
        echo $result;
        exit();
    }

    if($uri[1] == 'verify_transaction'){
        $data = file_get_contents('php://input');
        $data = json_decode($data, true);
        $email = $data["email"];
        $ref = $data["reference"];
        
        $controller->verify_transaction($email,$ref);
        exit();
    }
    
    $page = $uri[1];
    $file_path = __DIR__.'\includes\\' . $page. '.php';
    if (!file_exists($file_path)){
        echo "Page ({$uri[1]}): {$file_path} not found";
        exit();
    }

    array_push($includes, $file_path);

    foreach($includes as $page){
        include $page;
    }

}


$txnId = null;
if($uri[1] == 'transaction-success'){
    $txnId = $uri[2] ?? null;
}


// pass the request method and user ID to the PersonController:
// $controller = new TxnListController($dbConnection, $requestMethod, $txnId);
// $result = $controller->processRequest();
// if (isset($result['location'])){
//     $redirect_url = $result['location'];
//     if($redirect_url != null){
//         header("Location: /$redirect_url");
//     }
// }










?>