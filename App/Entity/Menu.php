<?php

namespace App\Entity;

use \App\Db\Mysql;
use Exception;

class Menu
{

    public string $entree;
    public function setEntree()
    {
        $db = Mysql::getInstance();
        $pdo = $db->getPDO();
        $query = $pdo->prepare('SELECT * FROM foods WHERE type = entree');
        try {
            if ($query->execute()) {
                $query->fetchAll();
                var_dump($query);
            } else {
                throw new Exception('Récupération des données impossibles');
            }
        } catch (Exception $e) {
        }
    }
}
