<?php

namespace App\Db;

use App\Db\Mysql;
use App\Entity\Error;

class FindIntoDb
{

    protected $allergen = [];
    protected $food = [];
    protected $foodType = [];
    protected $users = [];
    protected $allMenu = [];
    protected $homeMenu = [];
    protected $scheduleValues = [];

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

    public function getAllMenu()
    {
        $this->allMenu = $this->findAllMenu();
        return $this->allMenu;
    }

    public function getHomeMenu($id)
    {
        $this->homeMenu = $this->findHomeMenu($id);
        return (!empty($this->homeMenu)) ? $this->homeMenu[0] : null;
    }
    public function getScheduleValues()
    {
        $this->scheduleValues = $this->findScheduleValue();
        return (!empty($this->scheduleValues)) ? $this->scheduleValues : null;
    }

    private function findAllAllergensIntoDb()
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

    private function findAllFood(string $type)
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

    private function foodType()
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

    private function findUsers()
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

    private function findAllMenu()
    {
        try {
            $db = Mysql::getInstance();
            $connect = $db->getPDO();
            $req = $connect->prepare('
            SELECT
            m.id AS menu_id,
            m.entree_id,
            m.plat_id,
            m.dessert_id,
            m.total_price,
            f_entree.id AS entree_id,
            f_entree.name AS entree_name,
            f_plat.id AS plat_id,
            f_plat.name AS plat_name,
            f_dessert.id AS dessert_id,
            f_dessert.name AS dessert_name
            FROM
            menu_admin AS m
            INNER JOIN foods AS f_entree ON m.entree_id = f_entree.id
            INNER JOIN foods AS f_plat ON m.plat_id = f_plat.id
            INNER JOIN foods AS f_dessert ON m.dessert_id = f_dessert.id;
            ');
            $allMenu = [];
            if ($req->execute()) {
                while ($row = $req->fetch(\PDO::FETCH_ASSOC)) {
                    $allMenu[] = [
                        'entree_id' => $row['entree_id'],
                        'entree_name' => $row['entree_name'],
                        'plat_id' => $row['plat_id'],
                        'plat_name' => $row['plat_name'],
                        'dessert_id' => $row['dessert_id'],
                        'dessert_name' => $row['dessert_name'],
                        'total_price' => $row['total_price'],
                    ];
                }
            }
            return $allMenu;
        } catch (\PDOException $e) {
            echo $e->getMessage();
        }
    }

    private function findHomeMenu($id)
    {
        try {
            $db = Mysql::getInstance();
            $connect = $db->getPDO();
            $req = $connect->prepare('
            SELECT
            m.id AS menu_id,
            m.menu_name AS menu_name,
            m.entree_id,
            m.plat_id,
            m.dessert_id,
            m.total_price,
            f_entree.id AS entree_id,
            f_entree.name AS entree_name,
            f_entree.allergen AS entree_allergen,
            f_plat.id AS plat_id,
            f_plat.name AS plat_name,
            f_plat.allergen AS plat_allergen,
            f_dessert.id AS dessert_id,
            f_dessert.name AS dessert_name,
            f_dessert.allergen AS dessert_allergen
        FROM
            home_menu AS m
            INNER JOIN foods AS f_entree ON m.entree_id = f_entree.id
            INNER JOIN foods AS f_plat ON m.plat_id = f_plat.id
            INNER JOIN foods AS f_dessert ON m.dessert_id = f_dessert.id
        WHERE
            m.id = :id;
            ');
            $req->bindValue(':id', $id, \PDO::PARAM_INT);
            if ($req->execute()) {
                while ($row = $req->fetch(\PDO::FETCH_ASSOC)) {
                    $homeMenu[] = [
                        'menu_id' => $row['menu_id'],
                        'entree_id' => $row['entree_id'],
                        'entree_name' => $row['entree_name'],
                        'entree_allergen' => $row['entree_allergen'],
                        'plat_id' => $row['plat_id'],
                        'plat_name' => $row['plat_name'],
                        'plat_allergen' => $row['plat_allergen'],
                        'dessert_id' => $row['dessert_id'],
                        'dessert_name' => $row['dessert_name'],
                        'dessert_allergen' => $row['dessert_allergen'],
                        'total_price' => $row['total_price'],

                    ];
                }
            } else {
                throw new Error(Error::MENU_NOT_CREATED);
            }
            return $homeMenu;
        } catch (\PDOException $e) {
            echo $e->getMessage();
        }
    }

    private function findScheduleValue(): array
    {
        try {
            $db = Mysql::getInstance();
            $connect = $db->getPDO();
            $req = $connect->prepare("
            SELECT *, 
            CASE day_of_week 
            WHEN 1 THEN 'lundi'
            WHEN 2 THEN 'mardi'
            WHEN 3 THEN 'mercredi'
            WHEN 4 THEN 'jeudi'
            WHEN 5 THEN 'vendredi'
            WHEN 6 THEN 'samedi'
            WHEN 7 THEN 'dimanche'
            END AS 'jour_de_la_semaine'
            from schedule");
            if ($req->execute()) {
                $response = $req->fetchAll(\PDO::FETCH_ASSOC);
                return $response;
            } else {
                throw new Error(Error::ERROR_APPEND);
            }
        } catch (Error $e) {
            echo $e->getMessage();
        }
    }
}
