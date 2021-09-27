<?php

namespace Src\Gateway;

class ReviewGateway
{
    private $db = null;
    private $table = null;

    public function __construct($db)
    {
        $this->db = $db;
        $this->table = 'reviews';
    }

    public function get_all($limit = 5)
    {
        $table = $this->table;
        $statement = "
            SELECT * FROM `$table` ORDER BY `id` DESC LIMIT $limit
        ";

        try {
            $statement = $this->db->query($statement);
            if ($statement) {
                $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
            } else {
                return $statement;
            }
            return $result;
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function insert(array $input)
    {
        $table = $this->table;
        $statement = "
        INSERT INTO `$table`
        (`name`, `email`, `review`, `modified`)
        VALUES
        (:name, :email, :review, now());
        ";

        try {
            $statement = $this->db->prepare($statement);
            if ($statement) {
                $statement->execute(array(
                    'name' => $input['name'],
                    'email' => $input['email'],
                    'review' => $input['review']
                ));
            } else {
                return "Couldn't prepare statement!";
            }

            $rowcount = $statement->rowCount();
            return $rowcount;
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
        WHERE `id` = $id;
        ";

        try {
            $statement = $this->db->prepare($statement);
            $statement->execute();
            return $statement->rowCount();
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }
}
