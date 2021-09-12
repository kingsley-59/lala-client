<?php

namespace Src\Gateway;

class UserGateway {

    private $db;
    private $table;

    public function __construct($db, $table){
        $this->db = $db;
        $this->table = $table;
    }

    public function findAll(){
        $table = $this->table;
        $statement = "
            SELECT
                id, firstname, lastname, email, phone_no
            FROM $table
        ";

        try {
            $statement = $this->db->query($statement);
            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function find_user($param, $value){
        $table = $this->table;
        $statement = "
            SELECT  
                id, firstname, lastname, email, phone_no
            FROM $table
            WHERE `$param` = '$value'
        ";

        try {
            $statement = $this->db->prepare($statement);
            $statement->execute();
            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
        
    }

    public function get_admin_users(){
        $table = $this->table;
        $statement = "
            SELECT
                id, name, email, pswd, phone, address, modified
            FROM $table
        ";

        try {
            $statement = $this->db->query($statement);
            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function add_admin_user($input){
        $table = $this->table;
        $statement = "
            INSERT INTO `$table` 
                (name, email, pswd, phone, address, modified)
            VALUES
                (:name, :email, :pswd, :phone, :address, now());
        ";

        try {
            $statement = $this->db->prepare($statement);
            $statement->execute(array(
                'name' => $input['name'],
                'email'  => $input['email'],
                'pswd' => $input['pswd'],
                'phone' => $input['phone'],
                'address' => $input['address'],
            ));
            return $statement->rowCount();
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }    
    }

    public function insert(Array $input)
    {
        
        $statement = "
            INSERT INTO person 
                (firstname, lastname, email, phone_no)
            VALUES
                (:firstname, :lastname, :email, :phone_no);
        ";

        try {
            $statement = $this->db->prepare($statement);
            $statement->execute(array(
                'firstname' => $input['firstname'],
                'lastname'  => $input['lastname'],
                'email' => $input['email'],
                'phone_no' => $input['phone_no'],
            ));
            return $statement->rowCount();
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }    
    }

    public function update($id, Array $input)
    {
        $statement = "
            UPDATE person
            SET 
                firstname = :firstname,
                lastname  = :lastname,
                email = :email,
                phone_no = :phone_no
            WHERE id = :id;
        ";

        try {
            $statement = $this->db->prepare($statement);
            $statement->execute(array(
                'id' => (int) $id,
                'firstname' => $input['firstname'],
                'lastname'  => $input['lastname'],
                'email' => $input['email'] ?? null,
                'phone_no' => $input['phone_no'] ?? null,
            ));
            return $statement->rowCount();
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }    
    }

    public function delete($id)
    {
        $statement = "
            DELETE FROM person
            WHERE id = :id;
        ";

        try {
            $statement = $this->db->prepare($statement);
            $statement->execute(array('id' => $id));
            return $statement->rowCount();
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }    
    }


}