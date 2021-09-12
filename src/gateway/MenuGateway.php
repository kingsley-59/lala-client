<?php



namespace Src\Gateway;

class MenuGateway
{
    private $db = null;
    private $table = null;

    public function __construct($db)
    {
        $this->db = $db;
        $this->table = 'menu';
    }

    public function get_all()
    {
        $table = $this->table;
        $statement = "
            SELECT * FROM `$table` ORDER BY `id` DESC
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
        (`meal_name`, `meal_desc`, `price`, `file_name`, `uploaded_on`)
        VALUES
        (:name, :desc, :price, :file_name, now());
        ";

        try {
            $statement = $this->db->prepare($statement);
            if ($statement) {
                $statement->execute(array(
                    'name' => $input['name'],
                    'desc' => $input['desc'],
                    'price' => $input['price'],
                    'file_name' => $input['file_name']
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
