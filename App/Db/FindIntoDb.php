<?php

namespace App\Db;

use App\Db\Mysql;
use Exception;

class FindIntoDb
{

    protected $allergen = [];
    protected $food = [];
    protected $foodType = [];
    protected $users = [];

    public function getAllergen()
    {
        $this->findAllAllergensIntoDb();
        return $this->allergen;
    }

    public function getFood($type)
    {
        $this->findAllFood($type);
        return $this->food;
    }

    public function getFoodType()
    {
        $this->foodType();
        return $this->foodType;
    }

    public function getUsers()
    {
        $this->findUsers();
        return $this->users;
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

    public function findAllFood(string $type)
    {
        try {
            $db = Mysql::getInstance();
            $connect = $db->getPDO();
            $req = $connect->prepare("SELECT * FROM foods WHERE type = :type");
            $req->bindValue(':type', $type, \PDO::PARAM_STR);
            if ($req->execute()) {
                $this->food = [];
                while ($row = $req->fetch(\PDO::FETCH_ASSOC)) {
                    $this->food[$row['name']] = $row['name'];
                }
            }
        } catch (\PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function foodType()
    {
        try {
            $db = Mysql::getInstance();
            $connect = $db->getPDO();
            $req = $connect->prepare("SELECT type FROM foods");
            if ($req->execute()) {
                $this->foodType = array();
                while ($row = $req->fetch(\PDO::FETCH_ASSOC)) {
                    $this->foodType[$row['type']] = $row['type'];
                }
                $order = ['entree', 'plat', 'dessert'];
                $this->foodType = array_intersect($order, $this->foodType);
            }
        } catch (\PDOException $e) {
            echo $e->getMessage();
        }
    }


    public function findUsers()
    {
        try {
            $db = Mysql::getInstance();
            $connect = $db->getPDO();
            $req = $connect->prepare("SELECT lastName, firstName FROM users ORDER BY lastName ASC");
            if ($req->execute()) {
                while ($row = $req->fetch(\PDO::FETCH_ASSOC)) {
                    $this->users[$row['firstName']] = ucfirst($row['lastName']) . ' ' . ucfirst($row['firstName']);
                }
            }
        } catch (\PDOException $e) {
            echo $e->getMessage();
        }
    }
}
