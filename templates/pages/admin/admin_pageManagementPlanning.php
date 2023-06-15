<?php
require_once _ROOTPATH_ . '/templates/header.php';
require_once _ROOTPATH_ . '/templates/adminPanel.php';

use App\Controller\ScheduleController;

$scheduleController = new ScheduleController;
if (isset($_POST['schedule'])) {
    $id = $_POST['schedule_id'];
    if ($id != 7) {
        $launchOpeningTime = $_POST["openingLaunch" . '-' . $id];
        $launchClosingTime = $_POST["closingLaunch" . '-' . $id];
        $dinnerOpeningTime = $_POST["openingDinner" . '-' . $id];
        $dinnerClosingTime = $_POST["closingDinner" . '-' . $id];
    } else {
        $launchOpeningTime = $_POST["openingLaunch" . '-' . $id];
        $launchClosingTime = $_POST["closingLaunch" . '-' . $id];
        $scheduleController->setHorairesIntoDb($id, $launchOpeningTime, $launchClosingTime, '', '');
    }
    // Fonction d'ajout des horaires en base de données avec param = id correspondant a l'id du jour en base de donnée
}
?>
<div class="container">
    <h1>Définir de nouvelles horaires</h1>
    <?= $scheduleController->scheduleForm(); ?>
    <h1>Voir le planning</h1>
    <form>
        <div class="mb-3">
            <label for="horaireMidi" class="form-label">ICI, IL AURA UN PLANNING</label>
        </div>
    </form>
</div>
<?php require_once _ROOTPATH_ . '/templates/footer.php' ?>