<?php
require_once _ROOTPATH_ . '/templates/header.php';

use App\Entity\Schedule;
use App\Entity\UserManagement\User;

$schedule = new Schedule();
$user = new User();
$user->setUserInformations();
$userInformations = $user->getUserInformations();

if (isset($_GET['date'])) {
    $date = $_GET['date'];
    $_POST['date'] = $date;
} else {
    $date = date('Y-m-d');
}

$timeInterval = $schedule->getScheduleInterval($date);
$jsonData = json_encode($timeInterval);

?>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('date').addEventListener('change', function(event) {
            event.preventDefault();
            var date = this.value;
            var jsonData = '<?php echo $jsonData; ?>';
            fetch('index.php?controller=reservation&date=' + encodeURIComponent(date), {
                    method: 'GET'
                })
                .then(function(response) {
                    if (response.ok) {
                        var formData = new FormData();
                        formData.append('date', date);
                        formData.append('jsonData', jsonData);
                        fetch('templates/pages/schedule_interval_select.php?date=' +
                                encodeURIComponent(date), {
                                    method: 'POST',
                                    body: formData
                                })
                            .then(function(response) {
                                if (response.ok) {
                                    return response.text();
                                } else {
                                    throw new Error('Erreur AJAX : ' + response.status);
                                }
                            })
                            .then(function(responseText) {
                                console.log(responseText);
                                document.getElementById('result').innerHTML = '';
                                document.getElementById('result').innerHTML = responseText;
                            })
                            .catch(function(error) {
                                console.log(error);
                            });
                    } else {
                        throw new Error('Erreur AJAX : ' + response.status);
                    }
                })
                .catch(function(error) {
                    console.log(error);
                });

        });
    });
</script>

<div class="container">
    <h1>Réserver une table</h1>
    <div id="reservationForm">
        <form method="POST">
            <div class="form-group">
                <label for="lastName">Votre nom de famille :</label>
                <input type="text" name="lastName" class="form-control" id="lastName" value="<?= isset($userInformations['lastName']) ? $userInformations['lastName'] : ''; ?>" placeholder="Votre nom de famille">
            </div>
            <div class="form-group">
                <label for="firstName">Votre prénom :</label>
                <input type="text" name="firstName" class="form-control" id="firstName" value="<?= isset($userInformations['firstName']) ? $userInformations['firstName'] : ''; ?>" placeholder="Votre prénom">
            </div>
            <div class="form-group">
                <label for="number_of_seats">Nombre de couverts :</label>
                <input type="number" name="companions" class="form-control" id="number_of_seats" value="<?= isset($userInformations['companions']) ? $userInformations['companions'] : ''; ?>" placeholder="Nombre de couverts">
            </div>
            <div class="form-group">
                <label for="date">Date :</label>
                <input type="date" name="date" value="<?= isset($_GET['date']) ? $_GET['date'] : date('Y-m-d'); ?>" class="form-control" id="date">
            </div>
            <div id="result">
                <!-- INSERT SCHEDULE LIST -->
            </div>
            <div class="form-group">
                <label for="allergies">Mention des allergies :</label>
                <input type="text" name="allergies" class="form-control" id="allergies" value="<?= isset($userInformations['allergen']) ? $userInformations['allergen'] : ''; ?>" placeholder="Mention des allergies">
            </div>
            <button type="submit" name="reservation" class="btn btn-primary">Valider</button>
        </form>
    </div>
</div>

<?php
require_once _ROOTPATH_ . '/templates/footer.php';
