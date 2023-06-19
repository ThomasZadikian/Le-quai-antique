<?php

namespace App\Entity;

use App\Db\FindIntoDb;

class Schedule
{
    public string $launch_time_open;
    public string $launch_time_close;
    public string $dinner_time_open;
    public string $dinner_time_close;
    public array $scheduleList = [];
    public array $IntervalTime = [];


    public function getSchedule($date): array
    {
        $searchInDb = new FindIntoDb;
        $schedule = $searchInDb->getScheduleValues();
        $selectedDayOfWeek = date('N', strtotime($date));
        foreach ($schedule as $id => $value) {
            if ($selectedDayOfWeek == $value['day_of_week']) {
                $scheduleSelected = [
                    'launch schedule' => [
                        $value['launch_opening_time'],
                        $value['launch_closing_time']
                    ],
                    'dinner schedule' => [
                        $value['dinner_opening_time'],
                        $value['dinner_closing_time'],
                    ]
                ];
            }
        }
        return $this->scheduleList = $scheduleSelected;
    }

    public function getScheduleInterval($date)
    {
        $scheduleArray = $this->getSchedule($date);
        $timeIntervalLaunch = [];
        $timeIntervalDinner = [];
        $startLaunchTime = strtotime($scheduleArray['launch schedule'][0]);
        $stopLaunchTime = strtotime($scheduleArray['launch schedule'][1]);
        $startDinnerTime = strtotime($scheduleArray['dinner schedule'][0]);
        $stopDinnerTime = strtotime($scheduleArray['dinner schedule'][1]);
        $currentIntervalLaunch = $startLaunchTime;
        $currentIntervalDinner = $startDinnerTime;
        while ($currentIntervalLaunch <= $stopLaunchTime) {
            $timeIntervalLaunch[] = date('H:i:s', $currentIntervalLaunch);
            $currentIntervalLaunch += 900;
        };
        while ($currentIntervalDinner <= $stopDinnerTime) {
            $timeIntervalDinner[] = date('H:i:s', $currentIntervalDinner);
            $currentIntervalDinner += 900;
        }
        // Retourner les intervalles de temps
        return $this->IntervalTime = [
            'launch' => $timeIntervalLaunch,
            'dinner' => $timeIntervalDinner
        ];
    }
}
