<?php

namespace App\Entity;

use Exception;

class Error extends Exception
{
    public const ERROR_APPEND = "<p class='alert alert-danger'>Une erreur est survenue, merci de contacter l'administrateur du site avec la date et l'heure de l'erreur</p>";
    public const INVALID_EMAIL = "<p class='alert alert-danger'>Votre adresse mail est incorrecte</p>";
    public const EMAIL_ALREADY_USE = "<p class='alert alert-danger'>Cette adresse mail est déjà utilisée</p>";
    public const INVALID_PASSWORD = "<p class='alert alert-danger'>Le mot de passe ne correspond pas à l'adresse mail</p>";
    public const PASSWORD_TO_SHORT = "<p class='alert alert-danger mb-0 mt-1'>le mot de passe est trop court</p><br>";
    public const PASSWORD_NOT_MATCH = "<p class='alert alert-danger mb-0 mt-1'>Les mots de passe ne correspondent pas</p><br>";
    public const FORM_NOT_COMPLETE = "<p class='alert alert-danger mb-0 mt-1'>Formulaire invalide, merci de compléter tout els champs et de respecter les contraintes</p><br>";
    public const FOOD_ALREADY_IN_DB = "<p class='alert alert-danger mb-0 mt-1'>Ce plat existe déjà, merci de regarder la liste des plats et de la supprimer si besoin</p><br>";
    public const PAGES_NOT_FOUND = "<p class='alert alert-danger mb-0 mt-1'>La page correspondante, n'existe pas. Vous allez être redirigé dans les 5 prochaines secondes</p><br>";

    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}
