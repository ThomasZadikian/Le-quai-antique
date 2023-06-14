<?php

namespace App\Controller;

use App\Entity\Error;
use App\Entity\CreateFoodManagement;

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

    public function addImages()
    {
        try {
            $nomFichier = $_FILES['file']['name'];
            $cheminFichier = _ROOTPATH_ . '\uploads/' . $nomFichier;
            if (move_uploaded_file($_FILES['file']['tmp_name'], $cheminFichier)) {
                echo '<p class="alert alert-success">Le fichier a été enregistré avec succès ! </p>';
            } else {
                throw new Error(Error::ERROR_APPEND);
            }
        } catch (Error $e) {
            echo $e->getMessage();
        }
    }

    public function deleteImage()
    {
        try {
            $uploadsDirectory = _ROOTPATH_ . '\uploads/';
            $imageName = $_POST['imageName'];
            $imagePath = $uploadsDirectory . $imageName[0];
            if (file_exists($imagePath)) {
                unlink($imagePath);
                echo '<p class="alert alert-success">Le fichier a été supprimé avec succès ! </p>';
            } else {
                throw new Error(Error::ERROR_APPEND);
            }
        } catch (Error $e) {
            echo $e->getMessage();
        }
    }

    public function changeImages()
    {
        try {

            $config = require_once _ROOTPATH_ . '/config.php';
            $imagesArray = $config['carrouselImages'];
            $newImagesArray = [];
            $uploadsDirectory = $config['uploadsDirectory'];
            $selectedImages = $_POST['imageName'];
            if (count($selectedImages) != 3) {
                throw new Error(Error::CHANGE_IMAGE_NOT_3);
                return;
            } else {
                foreach ($selectedImages as $index => $name) {
                    $imageName = basename($name);
                    $newImagesArray[] = $imageName;
                }
                $config['carrouselImages'] = $newImagesArray;
                $this->updateConfigFile($config);
                echo "Les images ont été modifiées avec succès!";
            }
        } catch (Error $e) {
            echo $e->getMessage();
        }
    }

    public function updateConfigFile($config)
    {
        $configFile = _ROOTPATH_ . '/config.php';
        $content = '<?php return ' . var_export($config, true) . ';';
        file_put_contents($configFile, $content);
    }

    public function displayAllImages($action, $instanceId, $selectType)
    {
        $uploadsDirectory = 'uploads/';
        $imageFiles = glob($uploadsDirectory . '*.{jpg,jpeg,png,gif}', GLOB_BRACE);
        $index = 0;
        foreach ($imageFiles as $imageFile) {
            echo '
               <div class="col-6 col-md-4 col-lg-2 mb-2">
                <div class="image-container">
                <label for="radio-.' . $instanceId . ' - ' . $index . '" class="image-label">
                <img src="' . $imageFile . '" alt="Image" class="img-fluid fixed-size-image">
                </label>
                <div class="image-actions">
                    <input type="' . $selectType . '" name="imageName[]" id="radio-.' . $instanceId . ' - ' . $index . '" value="' . basename($imageFile) . '">
                    <label>' . ucfirst($action) . '</label>
                </div>
                </div>
               </div>';
            $index++;
        }
    }
}
