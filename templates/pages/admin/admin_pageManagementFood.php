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
    <h1>Page d'administration</h1>

    <h2>Formulaire de création de plats</h2>
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
        <h1>Quels sont les plats déjà existant ?</h1>
        <div class='col-4'>
            <h2>Les entrées : </h2>
            <?php
            foreach ($searchInDb->getEntry() as $id => $name) {
                echo
                "<div class='mt-1 mb-1'>
            <input class='form-check-input' type='checkbox' id=checkbox_$id name='allergens[]' value='$name' >
            <label for='checkbox_$id'>" . ucfirst($name) . "</label></div>";
            }
            ?>
        </div>
    </div>

    <h2>Formulaire de définition d'horaire</h2>
    <form>
        <div class="mb-3">
            <label for="horaireMidi" class="form-label">Horaire du midi (Lundi - Vendredi)</label>
            <input type="text" class="form-control" id="horaireMidi" required>
        </div>
        <div class="mb-3">
            <label for="horaireSoir" class="form-label">Horaire du soir (Lundi - Vendredi)</label>
            <input type="text" class="form-control" id="horaireSoir" required>
        </div>
        <button type="submit" class="btn btn-primary">Enregistrer</button>
    </form>

    <h2>Outil de suppression d'utilisateurs</h2>
    <form>
        <div class="mb-3">
            <label for="utilisateurs" class="form-label">Utilisateurs</label>
            <select multiple class="form-select" id="utilisateurs">
                <option value="utilisateur1">Utilisateur 1</option>
                <option value="utilisateur2">Utilisateur 2</option>
                <option value="utilisateur3">Utilisateur 3</option>
            </select>
        </div>
        <button type="submit" class="btn btn-danger">Supprimer</button>
    </form>
</div>
<?php require_once _ROOTPATH_ . '/templates/footer.php' ?>