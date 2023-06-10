<?php
require_once _ROOTPATH_ . '/templates/header.php';
require_once _ROOTPATH_ . '/templates/adminPanel.php';

use App\Db\FindIntoDb;
use App\Entity\CreatedFood;

$searchInDb = new FindIntoDb;
?>
<div class="container">
    <h1>Définir de nouvelles horaires</h1>
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
    <h1>Voir le planning</h1>
    <form>
        <div class="mb-3">
            <label for="horaireMidi" class="form-label">ICI, IL AURA UN PLANNING</label>
        </div>
    </form>
</div>
<?php require_once _ROOTPATH_ . '/templates/footer.php' ?>