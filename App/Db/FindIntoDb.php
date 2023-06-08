<?php

namespace App\Db;

use App\Db\Mysql;
use Exception;

class FindIntoDb
{

    protected $allergen = [];

    public function getResult()
    {
        return $this->allergen;
    }

    public function findAllAllergensIntoDb()
    {
        try {
            $db = Mysql::getInstance();
            if (!isset($filter)) {
                $connect = $db->getPDO();
                $req = $connect->prepare("SELECT * FROM allergen");
                if ($req->execute()) {
                    while ($row = $req->fetch(\PDO::FETCH_ASSOC)) {
                        $this->allergen[$row['id']] = $row['name'];
                    }
                }
            }
        } catch (\PDOException $e) {
            echo $e->getMessage();
        }
    }
}
