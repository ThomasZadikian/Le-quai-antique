<?php

namespace App\Entity;

use App\Db\FindIntoDb;
use App\Entity\UserManagement\User;
use App\Entity\Error;

class Reservation
{
    public function verifyInformations($date)
    {
        $searchInDb = new FindIntoDb;
        $schedule = $searchInDb->getScheduleValues();

        $selectedDayOfWeek = date('N', strtotime($date));

        foreach ($schedule as $key => $entry) {
            if ($entry['day_of_week'] == $selectedDayOfWeek) {
            }
            //LOGIC FOR CHECK IF DAY = ID in DB
        }
    }
}
