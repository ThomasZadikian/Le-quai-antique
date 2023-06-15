<?php
require_once _ROOTPATH_ . '/templates/header.php';

use App\Entity\Reservation;
use App\Entity\UserManagement\User;

$reservation = new Reservation;
$user = new User;
$user->setUserInformations();
if (isset($_POST['date'])) {
    $date = $_POST['date'];
    $userInformations = $user->getUserInformations();
}

?>
<script>
    $(document).ready(function() {
        $('#date').on('change', function() {
            let selectedDate = $(this).val();
            $.post('index.php?controller=reservation', {
                action: 'date',
                date: selectedDate
            }, function(response) {
                console.log(response);
                $('#time').html(response);
            });
        });
    });
</script>


<div class="container">
    <h1>Réserver une table</h1>
    <div id="reservationForm">
        <form method="post">
            <div class="form-group">
                <label for="lastName">Votre nom de famille </label>
                <input type="text" name='firstName' class="form-control" id="lastName" value="<?= $userInformations['lastName'] ?>" placeholder="Nombre de couverts">
            </div>
            <div class="form-group">
                <label for="firstName">Votre nom de famille </label>
                <input type="text" name="lastName" class="form-control" id="firstName" value="<?= $userInformations['firstName'] ?>" placeholder="Nombre de couverts">
            </div>
            <div class="form-group">
                <label for="number_of_seats">Nombre de couverts :</label>
                <input type="number" name='companions' class="form-control" id="number_of_seats" value="<?= $userInformations['companions'] ?>" placeholder="Nombre de couverts">
            </div>

            <div class="form-group">
                <label for="date">Date :</label>
                <input type="date" name="date" class="form-control" id="date">
                <input type="hidden" name="action" value="generateTimeSlots">
            </div>

            <div class="form-group">
                <label for="time">Heure prévue :</label>
                <select class="form-control" id="time">
                    <option value="">NAME OF RESERVATION SLOT</option>
                </select>
            </div>

            <div class=" form-group">
                <label for="allergies">Mention des allergies :</label>
                <input type="text" class="form-control" id="allergies" value="<?= $userInformations['allergen'] ?>" placeholder="Mention des allergies"></input>
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
