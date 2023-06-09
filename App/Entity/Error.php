<?php

namespace App\Entity;

use Exception;

class Error extends Exception
{
    public const ERROR_APPEND = "<p class='alert alert-danger'>Une erreur est survenue, merci de contacter l'administrateur du site avec la date et l'heure de l'erreur</p>";
    public const INVALID_EMAIL = "<p class='alert alert-danger'>Votre adresse mail est incorrecte</p>";
    public const INVALID_PASSWORD = "<p class='alert alert-danger'>Le mot de passe ne correspond pas à l'adresse mail</p>";

    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}
