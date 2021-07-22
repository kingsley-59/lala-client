<?php

require 'vendor/autoload.php';

use Src\System\DatabaseConnector;
use Src\Controller\TxnListController;
//use Dotenv;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$dbConnection = (new DatabaseConnector)->getConnection();
$dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

//echo $_ENV['OKTAAUDIENCE'];
header("Access-Control-Allow-Origin: *");
//header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode('/', $uri);

$includes = array();

if(isset($uri[1]) && !empty($uri[1])){
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

//authenticate the request with Okta:
// if (! authenticate()) {
//     header("HTTP/1.1 401 Unauthorized");
//     exit('Unauthorized');
// }

$requestMethod = $_SERVER["REQUEST_METHOD"];

// pass the request method and user ID to the PersonController:
$controller = new TxnListController($dbConnection, $requestMethod, $txnId);
$result = $controller->processRequest();
if (isset($result['location'])){
    $redirect_url = $result['location'];
    if($redirect_url != null){
        header("Location: /$redirect_url");
    }
}


?>