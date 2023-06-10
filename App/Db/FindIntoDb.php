<?php

namespace App\Db;

use App\Db\Mysql;
use Exception;

class FindIntoDb
{

    protected $allergen = [];
    protected $entry = [];

    public function getAllergen()
    {
        $this->findAllAllergensIntoDb();
        return $this->allergen;
    }
    public function getEntry()
    {
        $this->findAllFoodEntry();
        return $this->entry;
    }

    public function findAllAllergensIntoDb()
    {
        try {
            $db = Mysql::getInstance();
            $connect = $db->getPDO();
            $req = $connect->prepare("SELECT * FROM allergen");
            if ($req->execute()) {
                while ($row = $req->fetch(\PDO::FETCH_ASSOC)) {
                    $this->allergen[$row['id']] = $row['name'];
                }
            }
        } catch (\PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function findAllFoodEntry()
    {
        try {
            $db = Mysql::getInstance();
            $connect = $db->getPDO();
            $req = $connect->prepare("SELECT * FROM foods WHERE type = 'entree'");
            if ($req->execute()) {
                while ($row = $req->fetch(\PDO::FETCH_ASSOC)) {
                    $this->entry[$row['id']] = $row['name'];
                }
            }
        } catch (\PDOException $e) {
            echo $e->getMessage();
        }
    }
}
