<?php

namespace App\Entity;

use App\Db\FindIntoDb;
use App\Entity\UserManagement\User;
use App\Entity\Error;

class Reservation
{
    public function setSchedule($date)
    {
        $searchInDb = new FindIntoDb;
        $schedule = $searchInDb->getScheduleValues();
        $selectedDayOfWeek = date('N', strtotime($date));
        foreach ($schedule as $key => $entry) {
            if ($entry['day_of_week'] == $selectedDayOfWeek) {
                $openingTime = strtotime($date . ' ' . $entry['launch_opening_time']);
                $closingTime = strtotime($date . ' ' . $entry['dinner_closing_time']);
                while ($openingTime <= $closingTime) {
                    echo '<option value="' . date('H:i', $openingTime) . '">' . date('H:i', $openingTime) . "\n" . '</option>';
                    $openingTime += 900;
                }
                return;
            }
        }
    }
}
