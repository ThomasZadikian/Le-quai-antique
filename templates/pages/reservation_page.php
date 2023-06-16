<?php
require_once _ROOTPATH_ . '/templates/header.php';

use App\Entity\Reservation;
use App\Entity\UserManagement\User;
use App\Db\FindIntoDb;

$reservation = new Reservation;
$date = date('Y-m-d');
var_dump($date);
$date = $_POST['date'];
echo $date;
if (isset($_POST['checkDate'])) {
}
?>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        let selectedDate = document.getElementById('date');
        selectedDate.addEventListener('change', function() {
            let formData = new FormData();
            formData.append('POST', selectedDate.value);
            console.log(selectedDate.value);
            let xhr = new XMLHttpRequest();
            xhr.open("POST", "index.php?controller=reservation");
            let response = xhr.responseText;
            xhr.send(formData);
            xhr.onload = function() {
                if (xhr.status != 200) {
                    console.log('Error 200');
                } else {
                    console.log(response);
                    console.log('Requête réussie');
                }
            }
        })
    })
</script>

<div class="container">
    <h1>Réserver une table</h1>
    <div id="reservationForm">
        <form method="POST">
            <div class="form-group">
                <label for="lastName">Votre nom de famille </label>
                <input type="text" name='firstName' class="form-control" id="lastName" value="<?= isset($userInformations['lastName']) ? $userInformations['lastName'] : ''; ?>" placeholder="Nombre de couverts">
            </div>
            <div class="form-group">
                <label for="firstName">Votre nom de famille </label>
                <input type="text" name="lastName" class="form-control" id="firstName" value="<?= isset($userInformations['firstName']) ? $userInformations['firstName'] : ''; ?>" placeholder="Nombre de couverts">
            </div>
            <div class="form-group">
                <label for="number_of_seats">Nombre de couverts :</label>
                <input type="number" name='companions' class="form-control" id="number_of_seats" value="<?= isset($userInformations['companions']) ? $userInformations['companions'] : ''; ?>" placeholder="Nombre de couverts">
            </div>
            <form method="POST">
                <form class="form-group">
                    <label for="date">Date :</label>
                    <input type="date" name="date" value="<?= isset($_POST['date']) ? $date : date('Y-m-d'); ?>" class="form-control" id="date">
                    <?= isset($_POST['checkDate']) ? $reservation->scheduleList($date) : '' ?>
                    <button type="submit" name="checkDate" class="btn btn-primary">Vérifier les dates</button>
                </form>
                <div class=" form-group">
                    <label for="allergies">Mention des allergies :</label>
                    <input type="text" class="form-control" id="allergies" value="<?= isset($userInformations['allergen']) ? $userInformations['allergen'] : ''; ?>" placeholder="Mention des allergies"></input>

                    <button type="submit" name="reservation" class="btn btn-primary">Valider</button>
            </form>
    </div>
</div>

<?php
require_once _ROOTPATH_ . '/templates/footer.php';
