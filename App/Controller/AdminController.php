<?php

namespace App\Controller;

use Error;
use App\Entity\FoodManagement;

class AdminController extends Controller
{
    public function route(): void
    {
        try {
            if (isset($_GET['adminAction']) && $_SESSION['role'] === 'admin') {
                switch ($_GET['adminAction']) {
                    case 'food':
                        $this->render('pages/admin/admin_pageManagementFood');
                        break;
                    case 'planning':
                        $this->render('pages/admin/admin_pageManagementPlanning');
                        break;
                    case 'users':
                        $this->render('pages/admin/admin_pageManagementUsers');
                        break;
                }
            } else {
                if (isset($_GET['action'])   && $_GET['action'] === 'admin') {
                    $adminRoute = new PageManagementController();
                    $adminRoute->route();
                }
            }
        } catch (\Exception $e) {
        }
    }

    public function addFoodfromSelection($postData)
    {
        $foodManagement = new FoodManagement;
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
        $foodManagement = new FoodManagement;
        try {
            $entree = $postData["entree"];
            $plat = $postData["plat"];
            $dessert = $postData["dessert"];
            $foodManagement->createMenu($entree, $plat, $dessert);
        } catch (Error $e) {
            echo $e->getMessage();
        }
    }
}
