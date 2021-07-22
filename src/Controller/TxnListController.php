<?php
namespace Src\Controller;

use Src\Gateway\TxnListGateway;

class TxnListController {

    private $db;
    private $requestMethod;
    private $txnId;

    private $txnGateway;

    public function __construct($db, $requestMethod, $txnId)
    {
        $this->db = $db;
        $this->requestMethod = $requestMethod;
        $this->userId = $txnId;

        $this->txnGateway = new TxnListGateway($db, "lala-transactions");
    }

    public function processRequest(){
        switch ($this->requestMethod) {
            case 'GET':
                if ($this->txnId) {
                    $response = $this->getTxnById($this->txnId);
                } else {
                    $response = $this->getAllTxns();
                };
                break;
            case 'POST':
                $response = $this->createTxnFromRequest();
                break;
            case 'PUT':
                $response = $this->updateTxnFromRequest($this->userId);
                break;
            case 'DELETE':
                $response = $this->deleteTxn($this->userId);
                break;
            default:
                $response = $this->notFoundResponse();
                break;
        }
        header($response['status_code_header']);
        if ($response['body']) {
            echo $response['body'];
        }
    }

    public function getTxnById($id){
        $result = $this->txnGateway->find($id);
        if (! $result) {
            return $this->notFoundResponse();
        }
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($result);
        $response['location'] = null;
        return $response;
    }

    public function getTxn($param, $value){
        $result = $this->txnGateway->find_user($param, $value);
        if (! $result) {
            return $this->notFoundResponse();
        }
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($result);
        $response['location'] = null;
        return $response;
    }

    public function getAllTxns(){
        $result = $this->txnGateway->findAll();
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($result);
        $response['location'] = null;
        return $response;
    }

    public function createTxnFromRequest(){
        // $input = (array) json_decode(file_get_contents('php://input'), TRUE);
        $input = array(
            "name" => $_POST["name"],
            "email" => $_POST["email"],
            "meal_order" => $_POST["order"],
            "txn_amount" => $_POST["amount"],
            "txn_id" => $_POST["transactionId"],
            "phone_no" => $_POST["phone_no"]
        );
        if (! $this->validatePerson($input)) {
            return $this->unprocessableEntityResponse();
        }
        $response = array();
        $this->txnGateway->insert($input);
        $response['status_code_header'] = 'HTTP/1.1 201 Created';
        $response['location'] = '/transaction-success/$input["txn_id"]';
        $response['body'] = null;
        return $response;
    }

    public function updateTxnFromRequest($id){
        $result = $this->txnGateway->find($id);
        if (! $result) {
            return $this->notFoundResponse();
        }
        $input = (array) json_decode(file_get_contents('php://input'), TRUE);
        if (! $this->validatePerson($input)) {
            return $this->unprocessableEntityResponse();
        }
        $this->txnGateway->update($id, $input);
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = null;
        $response['location'] = null;
        return $response;
    }

    public function deleteTxn($id){

    }
    
    public function validatePerson($input){
        if (! isset($input['name'])) {
            return false;
        }
        if (! isset($input['email'])) {
            return false;
        }
        return true;
    }

    public function unprocessableEntityResponse(){
        $response['status_code_header'] = 'HTTP/1.1 422 Unprocessable Entity';
        $response['body'] = json_encode([
            'error' => 'Invalid input'
        ]);
        return $response;
    }

    public function notFoundResponse(){
        $response['status_code_header'] = 'HTTP/1.1 404 Not Found';
        $response['body'] = null;
        return $response;
    }


}