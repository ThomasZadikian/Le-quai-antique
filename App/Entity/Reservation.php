<?php

namespace App\Entity;

use App\Db\FindIntoDb;
use App\Entity\UserManagement\User;
use App\Entity\Error;

class Reservation
{
    protected $scheduleSelectedArray = [];

    public function getSchedule($date)
    {
        return $this->scheduleSelectedArray = $this->getScheduleSelected($date);
    }

    public function getScheduleSelected($date): array
    {
        $searchInDb = new FindIntoDb;
        $schedule = $searchInDb->getScheduleValues();
        $selectedDayOfWeek = date('N', strtotime($date));
        foreach ($schedule as $id => $value) {
            if ($selectedDayOfWeek == $value['day_of_week']) {
                $scheduleSelected = [
                    'launch schedule' => [
                        $launchOpenTime = $value['launch_opening_time'],
                        $launchCloseTime = $value['launch_closing_time']
                    ],
                    'dinner schedule' => [
                        $dinnerOpenTime = $value['dinner_opening_time'],
                        $dinnerCloseTime = $value['dinner_closing_time'],
                    ]
                ];
            }
        }
        return $scheduleSelected;
    }

    public function scheduleList($date)
    {
        $scheduleArray = $this->getSchedule($date);

        echo '<div class="container">
            <div class="row">

                <div class="col-6 mt-3 mb-3"> Horaires du midi :
                <select class="form-control" id="launch">';
        // horaire pour le midi
        foreach ($scheduleArray['launch schedule'] as $key => $value) {
            echo '<option value="' . $value . '">' . $value . '</option>';
        }
        echo
        '   </select>
                </div>
                <div class="col-6 mt-3 mb-3"> Horaires du soir :
                <select class="form-control" id="dinner">';
        // horaire pour le soir
        foreach ($scheduleArray['dinner schedule'] as $key => $value) {
            echo '<option value="' . $value . '">' . $value . '</option>';
        }
        echo
        '   </select>
                </div>
            </div>
            </div>';
    }
}
