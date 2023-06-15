<?php

namespace App\Controller;

use App\Db\FindIntoDb;
use App\Entity\Error;
use App\Db\Mysql;

class ScheduleController
{
    public function scheduleForm()
    {
        $findScheduleValues = new FindIntoDb;
        $scheduleValues = $findScheduleValues->getScheduleValues();
        echo '<div class="mb-3 row">';
        foreach ($scheduleValues as $id => $value) {
            // need to up $id by one because id in db start at 1
            $id = $id + 1;
            if ($value['jour_de_la_semaine'] != 'dimanche') {
                echo
                '<form method="POST" class="col-4 mb-3">
                <h2>' . ucfirst($value['jour_de_la_semaine']) . '</h2>
                <input type="hidden" name="schedule_id" value="' . $id . '">
                <div class="mb-3">
                    <label for="openingLaunch-' . $id . '" class="form-label">Ouverture midi</label>
                    <input type="text" class="form-control" name="openingLaunch-' . $id . '" id="openingLaunch-' . $id . '" pattern="^([01]\d|2[0-3]):([0-5]\d):([0-5]\d)$" title="Entrez une heure valide au format HH:MM:SS" required>
                </div>
                <div class="mb-3">
                    <label for="closingLaunch-' . $id . '" class="form-label">Fermeture midi</label>
                    <input type="text" class="form-control" name="closingLaunch-' . $id . '" id="closingLaunch-' . $id . '" pattern="^([01]\d|2[0-3]):([0-5]\d):([0-5]\d)$" title="Entrez une heure valide au format HH:MM:SS" required>
                </div>
                <div class="mb-3">
                    <label for="openingDinner-' . $id . '" class="form-label">Ouverture soir</label>
                    <input type="text" class="form-control" name="openingDinner-' . $id . '" id="openingDinner-' . $id . '" pattern="^([01]\d|2[0-3]):([0-5]\d):([0-5]\d)$" title="Entrez une heure valide au format HH:MM:SS" required>
                </div>
                <div class="mb-3">
                    <label for="closingDinner-' . $id . '" class="form-label">Fermeture soir</label>
                    <input type="text" class="form-control" name="closingDinner-' . $id . '" id="closingDinner-' . $id . '" pattern="^([01]\d|2[0-3]):([0-5]\d):([0-5]\d)$" title="Entrez une heure valide au format HH:MM:SS" required>
                </div>
                <button type="submit" name="schedule" class="btn btn-primary">Enregistrer</button>
            </form>';
            } else {
                echo
                '<form method="POST" class="col-4 mb-3">
                <h2>' . ucfirst($value['jour_de_la_semaine']) . '</h2>
                <input type="hidden" name="schedule_id" value="' . $id . '">
                <div>
                <label for="horaireMidi-' . $id . '" class="form-label">Ouverture midi</label>
                <input type="text" class="form-control" name="openingLaunch-' . $id . '" id="horaireMidi-' . $id . '" pattern="^([01]\d|2[0-3]):([0-5]\d):([0-5]\d)$" title="Entrez une heure valide au format HH:MM:SS" required>
                </div>
                <div>
                <label for="horaireSoir-' . $id . '" class="form-label"> Fermeture midi</label>
                <input type="text" class="form-control" name="closingLaunch-' . $id . '" id="horaireSoir-' . $id . '" pattern="^([01]\d|2[0-3]):([0-5]\d):([0-5]\d)$" title="Entrez une heure valide au format HH:MM:SS" required>
                </div>
                <button type="submit" name="schedule" class="btn btn-primary">Enregistrer</button>
            </form>';
            }
        }
        echo '</div>';
    }

    public function setHorairesIntoDb($id, $launchOpeningTime, $launchClosingTime, $dinnerOpeningTime, $dinnerClosingTime)
    {
        try {
            $db = Mysql::getInstance();
            $connect = $db->getPDO();
            $req = $connect->prepare('UPDATE schedule SET 
            launch_opening_time = :launch_opening_time,
            launch_closing_time = :launch_closing_time,
            dinner_opening_time = :dinner_opening_time,
            dinner_closing_time = :dinner_closing_time
            WHERE id = :id');
            $req->bindValue(':id', $id, \PDO::PARAM_INT);
            $req->bindValue(':launch_opening_time', $launchOpeningTime, \PDO::PARAM_STR);
            $req->bindValue(':launch_closing_time', $launchClosingTime, \PDO::PARAM_STR);
            $req->bindValue(':dinner_opening_time', $dinnerOpeningTime, \PDO::PARAM_STR);
            $req->bindValue(':dinner_closing_time', $dinnerClosingTime, \PDO::PARAM_STR);
            if ($req->execute()) {
                echo '<p class="alert alert-success">Les horaires ont bien été mise à jour</p>';
            } else {
                throw new Error(Error::ERROR_APPEND);
            }
        } catch (Error $e) {
            echo $e->getMessage();
        }
    }
}
