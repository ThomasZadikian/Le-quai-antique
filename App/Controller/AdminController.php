<?php

namespace App\Controller;

use Error;
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
        $nomFichier = $_FILES['file']['name'];
        $cheminFichier = _ROOTPATH_ . '\uploads/' . $nomFichier;
        if (move_uploaded_file($_FILES['file']['tmp_name'], $cheminFichier)) {
            // Le fichier a été téléchargé avec succès
            // Vous pouvez effectuer d'autres opérations ici, comme enregistrer le chemin du fichier dans la base de données
            echo 'Fichier téléchargé avec succès !';
        } else {
            // Une erreur s'est produite lors du téléchargement du fichier
            echo 'Une erreur s\'est produite lors du téléchargement du fichier.';
        }
    }

    public function deleteImage()
    {
        $uploadsDirectory = _ROOTPATH_ . '\uploads/';
        $imageName = $_POST['imageName'];
        $imagePath = $uploadsDirectory . $imageName;
        if (file_exists($imagePath)) {
            unlink($imagePath);
            echo 'L\'image a été supprimée avec succès.';
        } else {
            echo 'Le fichier n\'existe pas.';
        }
    }

    public function changeImages()
    {
        $config = require_once _ROOTPATH_ . '/config.php';
        $imagesArray = $config['carrouselImages'];
        $newImagesArray = [];
        $uploadsDirectory = $config['uploadsDirectory'];
        $selectedImages = $_POST['imageName'];
        foreach ($selectedImages as $index => $path) {
            $imageName = basename($path);
            $newImagesArray[] = $imageName;
        }
        $config['carrouselImages'] = $newImagesArray;
        $this->updateConfigFile($config);
        echo "Les images ont été modifiées avec succès!";
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

    public function changeCarousselImages()
    {
        $uploadsDirectory = 'uploads/';
        $newImages = $_FILES['newImages'];
    }
}
