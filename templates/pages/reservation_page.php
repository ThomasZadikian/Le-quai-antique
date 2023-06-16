<?php
require_once _ROOTPATH_ . '/templates/header.php';

use App\Entity\Reservation;
use App\Entity\UserManagement\User;

$user = new User;
$user->setUserInformations();
$userInformations = $user->getUserInformations();
if (isset($_POST['date'])) {
    $date = $_POST['date'];
    $reservation = new Reservation;
}

?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        let request = new XMLHttpRequest();
        let date = document.getElementById('date');
        date.addEventListener('change', function() {
            event.preventDefault();
            let selectedDate = date.value;
            let formData = new FormData();
            formData.append('date', selectedDate);
            console.log(selectedDate);
            request.open("POST", "index.php?controller=reservation", true);
            request.onreadystatechange = function() {
                if (request.readyState === 4 && request.status === 200) {
                    console.log("La requête s'est effectuée avec succès");
                    document.getElementById("selectedDate").innerHTML = request.responseText;
                }
            }
            request.send(formData);
        });
    });
</script>

<div class="container">
    <div id="selectedDate"></div>
    <h1>Réserver une table</h1>
    <div id="reservationForm">
        <form method="post">
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

            <div class="form-group">
                <label for="date">Date :</label>
                <input type="date" name="date" class="form-control" id="date">
                <input type="hidden" name="action" value="generateTimeSlots">
            </div>

            <div class="form-group">
                <label for="time">Heure prévue :</label>
                <select class="form-control" id="time">
                    <?= isset($_POST['date']) ? $reservation->setSchedule($date) : '<option>Veuillez sélectionner une date</option>' ?>
                </select>
            </div>

            <div class=" form-group">
                <label for="allergies">Mention des allergies :</label>
                <input type="text" class="form-control" id="allergies" value="<?= isset($userInformations['allergen']) ? $userInformations['allergen'] : ''; ?>" placeholder="Mention des allergies"></input>
            </div>

            <button type="submit" name="reservation" class="btn btn-primary">Valider</button>
        </form>
    </div>

    <div id="availabilityMessage" style="display: none;">
        <!-- Show availability message dynamically using JavaScript or PHP -->
        <p>Places disponibles</p>
    </div>
</div>

<?php
require_once _ROOTPATH_ . '/templates/footer.php';
