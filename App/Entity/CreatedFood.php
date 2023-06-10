<?php

namespace App\Entity;

use App\Db\Mysql;
use PDO;
use Exception;

class CreatedFood
{
    public function createdFood(string $name, string $type, string $allergen, string $description)
    {
        try {
            $db = Mysql::getInstance();
            $connect = $db->getPDO();
            //Vérification d'un plat déjà existant
            $req = $connect->prepare('SELECT * FROM foods WHERE name = :name');
            $req->bindValue(':name', $name, PDO::PARAM_STR);
            $req->execute();
            $result = $req->fetchAll(\PDO::FETCH_ASSOC);
            if ($result) {
                throw new Error(Error::FOOD_ALREADY_IN_DB);
            } else {
                $req = $connect->prepare('INSERT INTO foods(id, name, allergen, description, type) VALUES (id, :name, :allergen, :description, :type)');
                $req->bindValue(':name', $name, PDO::PARAM_STR);
                $req->bindValue(':allergen', $allergen, PDO::PARAM_STR);
                $req->bindValue(':description', $description, PDO::PARAM_STR);
                $req->bindValue(':type', $type, PDO::PARAM_STR);
                if ($req->execute()) {
                    echo 'Plat ajouté en base de donnée';
                    unset($_POST);
                } else {
                    throw new Error(Error::ERROR_APPEND);
                }
            }
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }
}
