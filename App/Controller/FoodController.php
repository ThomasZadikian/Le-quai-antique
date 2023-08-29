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
        <li class="list-group-item bg-dark text-white"> Entrée : <strong>' . $homeMenu['entree_name'] . '</strong></li>
        <li class="list-group-item bg-dark text-white"> Plat : <strong>' . $homeMenu['plat_name'] . ' </strong></li>
        <li class="list-group-item bg-dark text-white"> Dessert : <strong>' . $homeMenu['dessert_name'] . ' </strong></li>
        <li class="list-group-item bg-dark text-white"> Prix total : <strong>' . $homeMenu['total_price'] . ' € </strong> ' . '</li>';
        $this->generateAlergensAccordions($id, $allergens);
        echo '</ul>';
    }

    public function generateFoodCard()
    {
        $searchInDb = new FindIntoDb;
        $allFood = $searchInDb->getFood('');
        $tools = new Tools;
        $sortByType = $tools->sortByType($allFood);

        $types = [
            'entree' => 'Nos entrées',
            'plat' => 'Nos plats',
            'dessert' => 'Nos desserts'
        ];

        echo '
        <div class="container">
        <div class="row">';

        foreach ($types as $type => $label) {
            echo '<div class="col-md-12 text-white">
                <h3>' . $label . '</h3>
            </div>';

            foreach ($sortByType as $key => $value) {
                if ($value['type'] === $type) {
                    echo '
                    <div class="col-md-6 mb-3 ">
                        <div class="card bg-dark text-white">
                            <div class="card-body">
                                <h5 class="card-title">' . $value['name'] . '</h5>
                                <p class="card-text">' . $value['description'] . '</p>
                                <div class="mb-3">
                                    <label for="allergen-' . $key . '" class="form-label">Allergènes :</label>';

                    $allergens = explode(',', $value['allergen']);

                    $this->generateAlergensAccordions($key, $allergens);
                    echo '</select>
                </div>
                <p class="card-text">Prix : ' . $value['price'] . ' €</p>
                </div>
                </div>
                </div>';
                }
            }
        }

        echo
        '
        </div>
    </div>';
    }

    public function generateAlergensAccordions($id, $allergensArray)
    {
        echo
        '<div class="accordion accordion-flush bg-dark text-white" id="accordionAllergens' . $id . '">
            <div class="accordion-item text-white">
                <h2 class="accordion-header">
                    <button class="accordion-button bg-dark text-white" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAllergens' . $id . '" aria-expanded="true" aria-controls="collapseAllergens' . $id . '">
                        Voir les allergènes de ce plat
                    </button>
                </h2>
            <div id="collapseAllergens' . $id . '" class="accordion-collapse collapse bg-dark" data-bs-parent="#accordionAllergens' . $id . '">
        <div class="accordion-body">';
        foreach ($allergensArray as $allergen) {
            if ($allergen !== '') {
                echo '<p value="' . trim($allergen) . '">' . ucfirst(trim($allergen)) . '</p>';
            } else {
                echo '<p value="aucun">Aucun</p>';
            }
        }

        echo '
            </div>
        </div>
        </div>
        </div> ';
    }
}
