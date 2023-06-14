<?php

namespace App\Entity;

use App\Db\Mysql;
use PDO;
use App\Entity\Error;
use Exception;

class CreateFoodManagement
{

    public function createFood($name, $type, $allAllergen, $foodDescription, $price)
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
                $req = $connect->prepare('INSERT INTO foods(id, name, allergen, description, type, price) VALUES (id, :name, :allergen, :description, :type, :price)');
                $req->bindValue(':name', $name, PDO::PARAM_STR);
                $req->bindValue(':allergen', $allAllergen, PDO::PARAM_STR);
                $req->bindValue(':description', $foodDescription, PDO::PARAM_STR);
                $req->bindValue(':type', $type, PDO::PARAM_STR);
                $req->bindValue(':price', $price, PDO::PARAM_STR);
                if ($req->execute()) {
                    echo "<p class='alert alert-success'>Plat ajouté en base de donnée</p>";
                    unset($_POST);
                } else {
                    throw new Error(Error::ERROR_APPEND);
                }
            }
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

    public function createMenu($entree, $plat, $dessert)
    {
        try {
            $foodList = [$entree, $plat, $dessert];
            $platsIds = [];
            $db = Mysql::getInstance();
            $connect = $db->getPDO();

            // Find IDs from foods
            $foodReq = $connect->prepare('SELECT id FROM foods WHERE name = :name');
            foreach ($foodList as $food) {
                $foodReq->bindValue(':name', $food);
                $foodReq->execute();
                $result = $foodReq->fetch(\PDO::FETCH_ASSOC);
                if ($result) {
                    $platsIds[] = $result['id'];
                }
            }
            $entreeId = $platsIds[0];
            $platId = $platsIds[1];
            $dessertId = $platsIds[2];

            //Prepare add menu_admin
            $menuReq = $connect->prepare('INSERT INTO menu_admin(entree_id,plat_id,dessert_id) VALUES(:entree_id,:plat_id,:dessert_id)');
            $menuReq->bindValue(':entree_id', $entreeId, \PDO::PARAM_INT);
            $menuReq->bindValue(':plat_id', $platId, \PDO::PARAM_INT);
            $menuReq->bindValue(':dessert_id', $dessertId, \PDO::PARAM_INT);
            if ($menuReq->execute()) {
                $lastIdCreated = $connect->lastInsertId();
                //Prepare update all price
                $updateTotalPrice = $connect->prepare('
                UPDATE menu_admin SET total_price = 
                (SELECT SUM(price) FROM foods WHERE id IN (:entree_id, :plat_id, :dessert_id) )
                WHERE id = :total_price_id
                ');
                $updateTotalPrice->bindValue(':entree_id', $entreeId, \PDO::PARAM_INT);
                $updateTotalPrice->bindValue(':plat_id', $platId, \PDO::PARAM_INT);
                $updateTotalPrice->bindValue(':dessert_id', $dessertId, \PDO::PARAM_INT);
                $updateTotalPrice->bindValue(':total_price_id', $lastIdCreated, \PDO::PARAM_INT);
                if ($updateTotalPrice->execute()) {
                    echo '<p class="alert alert-success">Le menu a bien été ajouté ! </p>';
                } else {
                    throw new Error(Error::MENU_NOT_CREATED);
                }
            } else {
                throw new Error(Error::MENU_NOT_CREATED);
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function createHomePageMenu($mealtime, $entreeId, $platId, $dessertId, $totalPrice)
    {
        try {
            $db = Mysql::getInstance();
            $connect = $db->getPDO();
            if ($mealtime === 'launch') {
                $req = $connect->prepare('UPDATE home_menu SET menu_name = :name, entree_id = :entree_id, plat_id = :plat_id, dessert_id = :dessert_id, total_price = :total_price WHERE id = 1');
                $req->bindValue(':name', 'menu midi', PDO::PARAM_STR);
                $req->bindValue(':entree_id', $entreeId, PDO::PARAM_STR);
                $req->bindValue(':plat_id', $platId, PDO::PARAM_STR);
                $req->bindValue(':dessert_id', $dessertId, PDO::PARAM_STR);
                $req->bindValue(':total_price', $totalPrice, PDO::PARAM_STR);
                if ($req->execute()) {
                    echo '<p class="alert alert-success">Le menu a bien été mis à jour ! </p>';
                } else {
                    throw new Error(Error::MENU_NOT_CREATED);
                }
            } elseif ($mealtime === 'dinner') {
                $req = $connect->prepare('UPDATE home_menu SET menu_name = :name, entree_id = :entree_id, plat_id = :plat_id, dessert_id = :dessert_id, total_price = :total_price WHERE id = 2');
                $req->bindValue(':name', 'menu midi', PDO::PARAM_STR);
                $req->bindValue(':entree_id', $entreeId, PDO::PARAM_STR);
                $req->bindValue(':plat_id', $platId, PDO::PARAM_STR);
                $req->bindValue(':dessert_id', $dessertId, PDO::PARAM_STR);
                $req->bindValue(':total_price', $totalPrice, PDO::PARAM_STR);
                if ($req->execute()) {
                    echo '<p class="alert alert-success">Le menu a bien été mis à jour ! </p>';
                } else {
                    throw new Error(Error::MENU_NOT_CREATED);
                }
            } else {
                echo 'Aucun temps de repas sélectionné';
            }
        } catch (Error $e) {
            $e->getMessage();
        }
    }
}
