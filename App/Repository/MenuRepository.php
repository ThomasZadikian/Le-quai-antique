<?php

namespace App\Repository;

use \App\Db\Mysql;
use App\Entity\Entree;
use \Exception;
use \PDO;

class MenuRepository
{
    public function findAllFoods(string $type)
    {
        $mysql = Mysql::getInstance();
        $pdo = $mysql->getPDO();
        $query = $pdo->prepare('SELECT * FROM foods WHERE type = :type');
        $query->bindValue(":type", $type, PDO::PARAM_STR);
        $query->execute();
        $result = $query->fetch(PDO::FETCH_ASSOC);

        // $entree = new Entree();
        // $entree->setId($result['id']);
        // $entree->setTitle($result['name']);
        // $entree->setDescription($result['description']);
        foreach ($result as $key => $value) {
            if ($key === 'name') {
                echo "<option value=" . $value . ">" . $value . "</option>";
                break;
            }
        }
    }
}
