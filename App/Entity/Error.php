<?php

namespace App\Entity;

use Exception;

class Error extends Exception
{
    public const INVALID_EMAIL = "<p class='alert alert-danger'>Votre adresse mail est incorrecte</p>";

    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}
