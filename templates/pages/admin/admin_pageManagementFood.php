<?php
require_once _ROOTPATH_ . '/templates/header.php';
require_once _ROOTPATH_ . '/templates/adminPanel.php';

use App\Controller\FoodController;

$foodManagement = new FoodController;

if (!empty($_POST)) {
    if (isset($_POST['foodSubmit'])) {
        $foodManagement->addFoodfromSelection($_POST);
    } else if (isset($_POST['menuSubmit'])) {
        $foodManagement->addMenuFromSelection($_POST['menu']);
    } else if (isset($_POST['midi'])) {
        var_dump($_POST);
        $foodManagement->addHomeMenuFromSelection('launch', $_POST['homeMenu']);
    } else if (isset($_POST['dinner'])) {
        var_dump($_POST);
        $foodManagement->addHomeMenuFromSelection('dinner', $_POST['homeMenu']);
    }
}
?>

<div class="container-fluid">
    <div class="container mt-4">
        <h2 class="mt-2">Créer un nouveau plat</h2>
        <form method="post">
            <div class="mb-3">
                <label for="foodName" class="form-label">Nom du plat</label>
                <input type="text" class="form-control" name="foodName" id="foodName" required>
            </div>
            <div class="mb-3">
                <label for="typePlat" class="form-label">Type de plat</label>
                <select class="form-select" name="typePlat" id="typePlat" required>
                    <option value="">Sélectionnez le type de plat</option>
                    <option name="entree" value="entree">Entrée</option>
                    <option name="plat" value="plat">Plat</option>
                    <option name="dessert" value="dessert">Dessert</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="allergenes" class="form-label">Allergènes</label>
                <div class="row">
                    <?= $foodManagement->generateAllergensCheckbox(); ?>
                </div>
            </div>
            <div class="mb-3">
                <label for="foodDescription" class="form-label">Description du plat</label>
                <input type="text" class="form-control" name="foodDescription" id="foodDescription" required>
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Prix de ce plat :</label>
                <input type="text" class="form-control" name="price" id="price" required pattern="[0-9]+([,.][0-9]+)?">
            </div>
            <button type="submit" name="foodSubmit" class="btn btn-primary">Créer</button>
        </form>
    </div>

    <div class="container mt-4">
        <div class="row">
            <h2 class="mt-3">Créer un nouveau menu :</h2>
            <form method="post" action="votre_page_de_traitement.php">
                <div class="row">
                    <?= $foodManagement->generateFoodsforMenu() ?>
                </div>
                <button type="submit" name="menuSubmit" class="btn btn-primary mt-2">Créer</button>
            </form>
        </div>
    </div>

    <div class="container mt-4">
        <div class="row">
            <div class="col-12 col-md-6 mb-3">
                <form method="post">
                    <h2 class="mt-3">Sélectionnez un menu pour le midi :</h2>
                    <?= $foodManagement->generateMenu() ?>
                    <button type="submit" name="midi" class="btn btn-primary mt-2">Créer</button>
                </form>
            </div>
            <div class="col-12 col-md-6 mb-3">
                <form method="post">
                    <h2 class="mt-3">Sélectionnez un menu pour le soir :</h2>
                    <?= $foodManagement->generateMenu() ?>
                    <button type="submit" name="dinner" class="btn btn-primary mt-2">Créer</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once _ROOTPATH_ . '/templates/footer.php' ?>