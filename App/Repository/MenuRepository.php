<?php

namespace App\Repository;

use \App\Db\Mysql;
use App\Entity\Entree;
use \Exception;
use \PDO;

class MenuRepository
{
    public function findEntree(string $type)
    {
        $mysql = Mysql::getInstance();
        $pdo = $mysql->getPDO();
        $query = $pdo->prepare('SELECT * FROM foods WHERE type = :type');
        $query->bindValue(":type", $type, PDO::PARAM_STR);
        $query->execute();
        $result = $query->fetch();
        var_dump($result);

        $entree = new Entree();
        $entree->setId($result['id']);
        $entree->setTitle($result['name']);
        $entree->setDescription($result['description']);

        // foreach ($result as $key => $value) {
        //     $entree->{'set' . ucfirst($key)}($value);
        //     echo $entree->getTitle();
        // }
    }
}
