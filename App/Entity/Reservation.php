<?php

namespace App\Entity;

use App\Db\FindIntoDb;
use App\Entity\UserManagement\User;
use App\Entity\Error;

class Reservation
{

    public function defaultCouvert()
    {
        $user = new User;
        $user->setUserInformations();
        $userInformations = $user->getUserInformations();
        if (isset($userInformations['companions'])) {
            echo $userInformations['companions'];
        }
    }
    // Intégrer récupération des disponibilités
    // intégrer récupération des allergies 

}
