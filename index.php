<?php

require 'vendor/autoload.php';
require 'src/gateway/MenuGateway.php';

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

    if($uri[1] == 'mark_as_redeemed'){
        $data = file_get_contents('php://input');
        $data = json_decode($data, true);
        $txn_id = $data["txn_id"];
        $orderGateway = new Src\Gateway\OrderGateway($dbConnection, 'orders');
        $result = $orderGateway->update($txn_id, 'redeemed', true);
        $response = ($result == 1) ? 'success' : 'failed';
        echo $response;
        
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



?>