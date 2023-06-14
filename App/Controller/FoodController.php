<?php

namespace App\Controller;

use App\Entity\CreateFoodManagement;
use App\Db\FindIntoDb;
use App\Repository\Tools;
use Error;

class FoodController
{
    public function addFoodfromSelection($postData)
    {
        $foodManagement = new CreateFoodManagement;
        try {
            $name = trim($postData['foodName']);
            $type = trim($postData['typePlat']);
            $allergen = isset($postData['allergens']) ? implode(' , ', $postData['allergens']) : '';
            $description = trim($postData['foodDescription']);
            $price = floatval($postData['price']);

            $foodManagement->createFood($name, $type, $allergen, $description, $price);

            echo "<p class='alert alert-success'>Plat ajouté en base de données</p>";
            unset($_POST);
        } catch (Error $e) {
            echo $e->getMessage();
        }
    }

    public function addMenuFromSelection($postData)
    {
        $foodManagement = new CreateFoodManagement;
        try {
            $entree = $postData["entree"];
            $plat = $postData["plat"];
            $dessert = $postData["dessert"];
            $foodManagement->createMenu($entree, $plat, $dessert);
        } catch (Error $e) {
            echo $e->getMessage();
        }
    }

    public function addHomeMenuFromSelection($mealtime, $postData)
    {
        $foodManagement = new CreateFoodManagement;
        $platsIds = explode(',', $postData);
        try {
            $entreeId = $platsIds[0];
            $platId = $platsIds[1];
            $dessertId = $platsIds[2];
            $totalPrice = $platsIds[3];
            $foodManagement->createHomePageMenu($mealtime, $entreeId, $platId, $dessertId, $totalPrice);
        } catch (Error $e) {
            echo $e->getMessage();
        }
    }

    public function generateAllergensCheckbox()
    {
        $searchInDb = new FindIntoDb;
        foreach ($searchInDb->getAllergen() as $id => $name) {
            echo
            "<div class='mt-1 mb-1 col-6 col-sm-4 col-md-3'>
            <input class='form-check-input' type='checkbox' id=checkbox_$id name='allergens[]' value='$name' >
            <label for='checkbox_$id'>" . ucfirst($name) . "</label></div>";
        }
    }

    public function generateFoodsforMenu()
    {
        $searchInDb = new FindIntoDb;
        foreach ($searchInDb->getFoodType() as $type) {
            echo "<div class='col-12 col-md-4'>";
            echo "<h4>Les " . ucfirst($type) . " :</h3>";
            foreach ($searchInDb->getFood($type) as $id => $name) {
                echo "<div class='mt-1 mb-1'>";
                echo "<input class='form-check-input me-2' type='radio' id='radio_$id' name='menu[$type]' value='$name' required>";
                echo "<label for='radio_$id'>" . ucfirst($name) . "</label>";
                echo "</div>";
            }
            echo "</div>";
        }
    }

    public function generateMenu()
    {
        $searchIntoDb = new FindIntoDb;
        $allMenu = $searchIntoDb->getAllMenu();
        echo '
        <div class="form-groupe">
        <select name="homeMenu" class="form-control">';
        foreach ($allMenu as $menu) {
            $entree = $menu['entree_name'];
            $plat = $menu['plat_name'];
            $dessert = $menu['dessert_name'];
            $price = $menu['total_price'];
            echo '<option value="' . $menu['entree_id'] . ',' . $menu['plat_id'] . ',' . $menu['dessert_id'] . ',' . $menu['total_price'] . '">' . $entree . ', ' . $plat . ', ' . $dessert . ', ' . $price . '</option>';
        }
        echo '</select></div>';
    }

    public function generateHomeMenu($id)
    {
        $searchIntoDb = new FindIntoDb;
        $sortAllergen = new Tools;
        $homeMenu = $searchIntoDb->getHomeMenu($id);
        $allergens = $sortAllergen->sortAllergens($homeMenu);
        echo
        '<ul class="list-group list-group-flush">
        <li class="list-group-item">' . $homeMenu['entree_name'] . '</li>
        <li class="list-group-item">' . $homeMenu['plat_name'] . '</li>
        <li class="list-group-item">' . $homeMenu['dessert_name'] . '</li>
        <li class="list-group-item">' . $homeMenu['total_price'] . ' € ' . '</li>
        <select class="form-select" aria-label="Menu déroulant">
        <option selected>Afficher la liste des allergenes </option>';
        foreach ($allergens as $id => $value) {
            echo '<option value="allergens">' . ucfirst($value) . '</option>';
        }
        echo '</select>
        </ul>';
    }
}
