<?php

namespace Src\Gateway;

class TxnListGateway{
    private $db = null;
    private $table = null;

    public function __construct($db, $tablename){
        $this->db = $db;
        $this->table = $tablename;
    }

    public function findAll(){
        $table = $this->table;
        $statement = "
            SELECT
                id, name, email, meal_order, amount, txn_id, phone_no, txn_time, order_collected
            FROM $table
        ";

        try {
            $statement = $this->db->query($statement);
            if($statement){
                $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
            }else{
                return $statement;
            }
            return $result;
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function find($id){
        $table = $this->table;
        $statement = "
            SELECT
                id, name, email, meal_order, amount, txn_id, phone_no, txn_time, order_collected
            FROM $table
            WHERE id = ?;
        ";
        
        try {
            $statement = $this->db->prepare($statement);
            $statement->execute(array($id));
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
                id, name, email, meal_order, amount, txn_id, phone_no, txn_time, order_collected
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

    public function insert(Array $input)
    {
        $table = $this->table;
        $statement = "
            INSERT INTO `$table` 
                (`name`, `email`, `meal_order`, `amount`, `txn_id`, `phone_no`, `txn_time`, `order_collected`)
            VALUES
                (:name, :email, :meal_order, :txn_amount, :txn_id, :phone_no, now(), FALSE);
        ";

        try {
            $statement = $this->db->prepare($statement);
            if($statement){
                $statement->execute(array(
                    'name' => $input['name'],
                    'email'  => $input['email'],
                    'meal_order' => $input['meal_order'],
                    'txn_amount' => $input['txn_amount'],
                    'txn_id' => $input['txn_id'],
                    'phone_no' => $input['phone_no'],
                ));
            }else{
                return "Couldn't prepare statement!";
            }
            
            return $statement->rowCount();
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }    
    }

    public function update($id, Array $input)
    {
        $table = $this->table;
        $statement = "
            UPDATE `$table`
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
        $table = $this->table;
        $statement = "
            DELETE FROM `$table`
            WHERE `id` = :id;
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

?>