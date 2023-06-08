<?php

namespace App\Entity;

use App\Db\Mysql;
use Exception;

class Register
{

    //Mettre les bonnes valeurs de la DB

    protected string $err_formIncomplete = '';
    protected string $err_passwordToShort = '';
    protected string $err_register = '';
    protected string $err_emailAlreadyUse = '';
    protected string $err_confPassword = '';
    protected string $err_dbConnect = '';
    protected string $validateRegistration = '';

    public function getErrFormIncomplete(): string
    {
        return $this->err_formIncomplete;
    }

    public function getErrPasswordToShort(): string
    {
        return $this->err_passwordToShort;
    }

    public function getErrRegister(): string
    {
        return $this->err_register;
    }

    public function getErrEmailAlreadyUse(): string
    {
        return $this->err_emailAlreadyUse;
    }

    public function getErrConfPassword(): string
    {
        return $this->err_confPassword;
    }

    public function getErrDbConnect(): string
    {
        return $this->err_formIncomplete;
    }

    public function getvalidateRegistration(): string
    {
        return $this->validateRegistration;
    }


    private function validateData($lastName, $firstName, $email, $password, $confpass, $companions, $phoneNumber, $allergen): bool
    {
        if (empty($lastName) || empty($firstName) || empty($email) || empty($password) || empty($companions)) {
            $this->err_formIncomplete = "<p class='alert alert-danger mb-0 mt-1'>Merci de compléter tout les champs</p><br>";
            return false;
        } else {
            // Ajouter vérification email (taille)
            if (strtolower($password) !== strtolower($confpass)) {
                $this->err_confPassword = "<p class='alert alert-danger mb-0 mt-1'>Les mots de passe ne correspondent pas</p><br>";
                return false;
            } else {
                if (strlen($password) < 8) {
                    $this->err_passwordToShort = "<p class='alert alert-danger mb-0 mt-1'>le mot de passe est trop court</p><br>";
                    return false;
                } else {
                    return true;
                }
            }
        }
    }

    public function registerUser($lastName, $firstName, $email, $password, $confpass, $companions, $phoneNumber, $allergen)
    {
        $this->validateData($lastName, $firstName, $email, $password, $confpass, $companions, $phoneNumber, $allergen);
        if ($this->validateData($lastName, $firstName, $email, $password, $confpass, $companions, $phoneNumber, $allergen)) {
            try {
                $db = Mysql::getInstance();
                $connect = $db->getPDO();
                $req = $connect->prepare("SELECT * FROM users");
                if ($req->execute()) {
                    $result = $req->fetchAll(\PDO::FETCH_ASSOC);
                    $req = $connect->prepare("
                        INSERT INTO users(id, email, lastName, firstname, password, companions, phoneNumber, allergen) 
                        VALUES 
                        (UUID(),:email,:lastName, :firstName,:password,:companions,:phoneNumber, :allergen)
                        ");
                    $req->bindValue(':email', strtolower($email), \PDO::PARAM_STR);
                    $req->bindValue(':lastName', strtolower($lastName), \PDO::PARAM_STR);
                    $req->bindValue(':firstName', strtolower($firstName), \PDO::PARAM_STR);
                    $req->bindValue(':password', password_hash((strval($password)), PASSWORD_BCRYPT));
                    $req->bindValue(':companions', $companions, \PDO::PARAM_INT);
                    $req->bindValue(':phoneNumber', $phoneNumber, \PDO::PARAM_STR);
                    $req->bindValue(':allergen', $allergen, \PDO::PARAM_STR);
                    if ($req->execute()) {
                        $this->validateRegistration = "<p class='alert alert-success mb-0 mt-1'>Inscription validée, merci !</p><br>";
                    } else {
                        echo 'Erreur lors de l\'insertion en base de donnée';
                    }
                }
            } catch (\PDOException $e) {
                if ($e->getCode() === '23000') {
                    error_log($e->getMessage() . "\n", 3, 'error.log');
                    $this->err_emailAlreadyUse = "<p class='alert alert-danger mb-0 mt-1'>Un autre utilisateur utilise déjà cette adresse mail</p><br>";
                } else {
                    error_log($e->getMessage() . "\n", 3, 'error.log');
                    $this->err_dbConnect = "<p class='alert alert-danger mb-0 mt-1'>Une erreur est survenue, merci de contacter l'administrateur du site</p><br>";
                }
            }
        }
    }
}
