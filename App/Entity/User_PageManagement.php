<?php

namespace App\Entity;

use App\Entity\User;

class User_PageManagement extends User
{
    public array $userInformation;
    protected array $userAllergen;

    public function getUserInformation(): array
    {
        $user = new User;
        $user->defineUser();
        return $this->userInformation = $user->getUserInformation();
    }

    public function changePassword($oldPassword, $newPassword)
    {
        parent::changePassword($oldPassword, $newPassword);
    }
}
