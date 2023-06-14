<?php
require_once _ROOTPATH_ . '/templates/header.php';
require_once _ROOTPATH_ . '/templates/adminPanel.php';

use App\Db\FindIntoDb;
use App\Controller\AdminController;

$adminController = new AdminController;

$searchInDb = new FindIntoDb;
if (isset($_POST['upload'])) {
    $adminController->addImages();
} elseif (isset($_POST['delete'])) {
    $adminController->deleteImage();
} elseif (isset($_POST['changeCarroussel'])) {
    $adminController->changeImages();
} elseif (isset($_POST['changemenuImages'])) {
    var_dump($_FILES);
}
?>
<div class="container">
    <div class="container mt-5 mb-5 alert alert-primary">
        <form method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="file" class="form-label">Sélectionnez un fichier :</label>
                <input type="file" class="form-control" name="file" id="file">
            </div>
            <button type="submit" name="upload" class="btn btn-primary">Télécharger</button>
        </form>
    </div>
    <div class="container mb-5">
        <div class="d-flex justify-content-around">
            <form class="m-2 alert alert-primary" method="POST">
                <h2>Modifier les images défilantes :</h2>
                <div class="row">
                    <?= $adminController->displayAllImages('modifier', 'carroussel', 'checkbox') ?>
                </div>
                <div>
                </div>
                <button type='button' class="btn btn-primary " name="changeCarroussel" type="submit">Modifier</button>
            </form>

            <!-- <form class="m-2 alert alert-primary" method="POST" enctype="multipart/form-data">
                <h2>Modifier les images des menus : </h2>
                <div class="row">
                    <?= $adminController->displayAllImages('modifier', 'menuImages', 'checkbox') ?>
                </div>
                <button type='button' class="btn btn-primary " name="TODO" type="submit">Modifier</button>
            </form> -->
        </div>
    </div>
    <div class="container alert alert-danger">
        <form method="post">
            <div class="row">
                <?= $adminController->displayAllImages('supprimer', 'deleteImages', 'radio') ?>
            </div>
            <button type="submit" name="delete" class="btn btn-danger">Supprimer l'image sélectionnée</button>
        </form>
    </div>


</div>

<?php require_once _ROOTPATH_ . '/templates/footer.php' ?>