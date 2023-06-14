<?php

namespace App\Entity\UserManagement;

use App\Db\Mysql;
use App\Entity\Error;

class Register extends User
{
    protected string $validateRegistration = '';

    public function getvalidateRegistration(): string
    {
        return $this->validateRegistration;
    }

    public function registerUser($lastName, $firstName, $email, $password, $confpass, $companions, $phoneNumber, $allergen)
    {
        parent::verifyRegisterInformations($lastName, $firstName, $email, $password, $confpass, $companions, $phoneNumber, $allergen);
        if (parent::verifyRegisterInformations($lastName, $firstName, $email, $password, $confpass, $companions, $phoneNumber, $allergen)) {
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
                        header("Refresh: 5; URL=index.php?controller=connect");
                        $this->validateRegistration = "<p class='alert alert-success mb-0 mt-1'>Inscription validée, merci ! Vous serez redirigé vers la page de connexion d'ici 5 secondes</p><br>";
                    } else {
                        throw new Error(Error::ERROR_APPEND);
                    }
                }
            } catch (\PDOException $e) {
                if ($e->getCode() === '23000') {
                    throw new Error(Error::EMAIL_ALREADY_USE);
                } else {
                    error_log($e->getMessage() . "\n", 3, 'error.log');
                    echo $e->getMessage();
                }
            }
        }
    }
}
