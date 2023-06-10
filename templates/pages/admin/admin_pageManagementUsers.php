<?php
require_once _ROOTPATH_ . '/templates/header.php';
require_once _ROOTPATH_ . '/templates/adminPanel.php';

use App\Db\FindIntoDb;
use App\Entity\CreatedFood;

$searchInDb = new FindIntoDb;

?>
<div class="container">
    <h1>Page d'administration</h1>
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