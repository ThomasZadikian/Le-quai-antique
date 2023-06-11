<?php

namespace App\Entity\UserManagement;


class User_PageManagement extends User
{
    public array $userInformation;
    protected array $userAllergen;

    public function getUserInformation(): array
    {
        parent::setUserInformations();
        return $this->userInformation = parent::getUserInformations();
    }

    public function changePassword($oldPassword, $newPassword)
    {
        parent::changePassword($oldPassword, $newPassword);
    }
}
