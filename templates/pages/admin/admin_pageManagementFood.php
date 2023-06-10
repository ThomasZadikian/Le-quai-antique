<?php
require_once _ROOTPATH_ . '/templates/header.php';
require_once _ROOTPATH_ . '/templates/adminPanel.php';

use App\Db\FindIntoDb;
use App\Entity\CreatedFood;

$searchInDb = new FindIntoDb;

if (!empty($_POST)) {
    extract($_POST);
    if (isset($_POST['foodSubmit'])) {
        $name = trim($foodName);
        $type = trim($typePlat);
        $allAllergen = isset($allergens) ? implode(' , ', $allergens) : '';
        $description = trim($foodDescription);
        $createdFood = new CreatedFood;
        $createdFood->createdFood($name, $type, $allAllergen, $foodDescription);
    }
}


?>
<div class="container">
    <h1 class='mt-2'>Créer un nouveau plat</h2>
        <form method="post">
            <div class="mb-3">
                <label for="foodName" class="form-label">Nom du plat</label>
                <input type="text" class="form-control" name='foodName' id="foodName" required>
            </div>
            <div class="mb-3">
                <label for="typePlat" class="form-label">Type de plat</label>
                <select class="form-select" name='typePlat' id="typePlat" required>
                    <option value="">Sélectionnez le type de plat</option>
                    <option name='entree' value="entree">Entrée</option>
                    <option name='plat' value="plat">Plat</option>
                    <option name='dessert' value="dessert">Dessert</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="allergenes" class="form-label">Allergènes</label>
                <!-- foreach checkbox with class FindIntoDb -->
                <div class="row">
                    <?php
                    foreach ($searchInDb->getAllergen() as $id => $name) {
                        echo
                        "<div class='mt-1 mb-1 col-3'>
                <input class='form-check-input' type='checkbox' id=checkbox_$id name='allergens[]' value='$name' >
                <label for='checkbox_$id'>" . ucfirst($name) . "</label></div>";
                    }
                    ?>
                </div>
            </div>
            <div class="mb-3">
                <label for="foodDescription" class="form-label">Description du plat</label>
                <input type="text" class="form-control" name='foodDescription' id="foodDescription" required>
            </div>
            <button type="submit" name='foodSubmit' class="btn btn-primary">Créer</button>
        </form>
        <div class="row">
            <h1 class='mt-3'>Créer un nouveau menu : </h1>
            <div class='row'>
                <?php
                foreach ($searchInDb->getFoodType() as $type) {
                    echo "<div class='col-4'>";
                    echo "<h2>Les " . ucfirst($type) . " :</h2>";
                    foreach ($searchInDb->getFood($type) as $id => $name) {
                        echo "<div class='mt-1 mb-1'>";
                        echo "<input class='form-check-input' type='checkbox' id='checkbox_$id' name='allergens[]' value='$name'>";
                        echo "<label for='checkbox_$id'>" . ucfirst($name) . "</label>";
                        echo "</div>";
                    }

                    echo "</div>";
                }
                ?>
            </div>
            <?php require_once _ROOTPATH_ . '/templates/footer.php' ?>