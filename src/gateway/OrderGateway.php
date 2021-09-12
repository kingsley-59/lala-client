<?php

namespace Src\Gateway;

class OrderGateway{
    private $db = null;
    private $table = null;

    public function __construct($db, $tablename){
        $this->db = $db;
        $this->table = $tablename;
    }

    public function get_all($limit = 20){
        $table = $this->table;
        $statement = "
            SELECT * FROM `$table` ORDER BY `id` DESC LIMIT $limit
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

    public function get_verified($limit = 20){
        $table = $this->table;
        $statement = "
            SELECT * FROM `$table` WHERE `txn_verified` = TRUE ORDER by `id` DESC LIMIT $limit
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

    public function get_unredeemed($limit = 20){
        $table = $this->table;
        $statement = "
            SELECT * FROM `$table` WHERE `redeemed` = FALSE ORDER by `id` DESC LIMIT $limit
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
                (`email`, `name`, gender, phone, order_details, total_amount, home_delivery, txn_id, txn_verified, delivery_details, order_time, redeemed, redeemed_time)
            VALUES
                (:email, :name, :gender, :phone, :order_details, :total_amount, :home_delivery, :txn_id, FALSE, :delivery_details, now(), FALSE, NULL);
        ";

        try {
            $statement = $this->db->prepare($statement);
            if($statement){
                $statement->execute(array(
                    'email' => $input['email'],  
                    'name'  => $input['name'],  
                    'gender' => $input['gender'],   
                    'phone' => $input['phone'],     
                    'order_details' => $input['order_details'],   
                    'total_amount'  => $input['total_amount'],
                    'home_delivery' => $input['home_delivery'],   
                    'txn_id' => $input['txn_id'],
                    'delivery_details' => $input['delivery_details'],   
                ));
            }else{
                return "Couldn't prepare statement!";
            }
            
            $rowcount =  $statement->rowCount();
            return "Data Saved! Rowcount: " . $rowcount;
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }    
    }

    public function update($email, $param, $value)
    {
        $table = $this->table;
        $statement = "
            UPDATE `$table`
            SET 
                `$param` = $value
            WHERE `email` = '$email';
        ";

        try {
            $statement = $this->db->prepare($statement);
            $statement->execute();
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

// id, email, name, gender, phone, order_details, total_amount, home_delivery, txn_id, delivery_details, order_time, redeemed, redeemed_time
?>