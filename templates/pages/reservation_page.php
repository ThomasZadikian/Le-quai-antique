<?php
require_once _ROOTPATH_ . '/templates/header.php';

use App\Entity\Reservation;
use App\Entity\UserManagement\User;

$reservation = new Reservation;
$user = new User;
$user->setUserInformations();
$userInformations = $user->getUserInformations();
?>

<div class="container">
    <h1>Réserver une table</h1>
    <div id="reservationForm">
        <form>
            <div class="form-group">
                <label for="lastName">Votre nom de famille </label>
                <input type="text" class="form-control" id="lastName" value="<?= $userInformations['lastName'] ?>" placeholder="Nombre de couverts">
            </div>
            <div class="form-group">
                <label for="firstName">Votre nom de famille </label>
                <input type="text" class="form-control" id="firstName" value="<?= $userInformations['firstName'] ?>" placeholder="Nombre de couverts">
            </div>
            <div class="form-group">
                <label for="number_of_seats">Nombre de couverts :</label>
                <input type="number" class="form-control" id="number_of_seats" value="<?= $userInformations['companions'] ?>" placeholder="Nombre de couverts">
            </div>

            <div class="form-group">
                <label for="date">Date :</label>
                <input type="date" class="form-control" id="date">
            </div>

            <div class="form-group">
                <label for="time">Heure prévue :</label>
                <select class="form-control" id="time">
                    <!-- Populate the available time slots dynamically using JavaScript or PHP -->
                    <option value="12:00">12:00</option>
                    <option value="12:15">12:15</option>
                    <option value="12:30">12:30</option>
                    <option value="12:45">12:45</option>
                    <option value="13:00">13:00</option>
                    <option value="13:15">13:15</option>
                    <option value="13:30">13:30</option>
                    <option value="13:45">13:45</option>
                    <option value="14:00">14:00</option>
                </select>
            </div>

            <div class="form-group">
                <label for="allergies">Mention des allergies :</label>
                <input type="text" class="form-control" id="allergies" value="<?= $userInformations['allergen'] ?>" placeholder="Mention des allergies"></input>
            </div>

            <button type="submit" class="btn btn-primary">Valider</button>
        </form>
    </div>

    <div id="availabilityMessage" style="display: none;">
        <!-- Show availability message dynamically using JavaScript or PHP -->
        <p>Places disponibles</p>
    </div>
</div>

<?php
require_once _ROOTPATH_ . '/templates/footer.php';
