<?php
namespace Src\Controller;

use Src\Gateway\UserGateway;

class UserController {

    private $db;
    private $tablename;
    private $usergateway;

    public function __construct($db, $tablename){
        $this->db = $db;
        $this->tablename = $tablename;

        $this->usergateway = new UserGateway($db, $tablename);
    }

    public function getAllUsers(){
        $result = $this->usergateway->findAll();
        if(!$result){
            return $this->notFoundResponse();
        }

        return $result;
    }

    public function getUser(){
        
    }

    public function notFoundResponse(){

    }

}