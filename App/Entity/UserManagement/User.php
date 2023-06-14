<?php

namespace App\Entity\UserManagement;

use PDO;
use App\Db\Mysql;
use App\Entity\Error;
use App\Entity\Session;

class User
{
    protected string $email;
    protected string $lastName;
    protected string $firstName;
    protected int $companions;
    protected string $allergen;
    protected string $phoneNumber;
    protected string $registerDate;
    protected string $role;
    protected array $userData = [];

    public function setUserInformations()
    {
        $this->email = $_SESSION['email'] ?? '';
        $this->lastName = $_SESSION['lastName'] ?? '';
        $this->firstName = $_SESSION['firstName'] ?? '';
        $this->companions = $_SESSION['companions'] ?? 0;
        $this->allergen = $_SESSION['allergen'] ?? '';
        $this->phoneNumber = $_SESSION['phoneNumber'] ?? '';
        $this->registerDate = $_SESSION['registerDate'] ?? '';
        $this->role = $_SESSION['role'] ?? 'user';
    }

    public function getUserInformations(): array
    {
        $this->userData = get_object_vars($this);
        return $this->userData;
    }

    public function changePassword($oldPassword, $newPassword)
    {
        try {
            $this->setUserInformations();
            $pdo = Mysql::getInstance();
            $connect = $pdo->getPDO();
            $req = $connect->prepare('SELECT * FROM users WHERE email = :email');
            $req->bindValue(':email', $this->email, \PDO::PARAM_STR);
            if ($req->execute()) {
                $userInformation = $req->fetch(PDO::FETCH_ASSOC);
                if (password_verify($oldPassword, $userInformation['password'])) {
                    $req = $connect->prepare('UPDATE users SET password = :password WHERE email = :email');
                    $req->bindValue(':password', password_hash($newPassword, PASSWORD_BCRYPT));
                    $req->bindValue(':email', $this->email);
                    if ($req->execute()) {
                        echo 'Changement de mot passe effectué avec succès. Vous aller être déconnecté. ';
                        Session::destroy();
                    } else {
                        throw new Error(Error::ERROR_APPEND);
                    }
                } else {
                    echo 'Erreur vérification password';
                }
            }
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

    protected function verifyConnectInformations(string $email, string $password)
    {
        try {
            $db = Mysql::getInstance();
            $req = $db->getPDO();
            $query = $req->prepare('SELECT email from users WHERE email = :email');
            $query->bindValue(':email', $email, \PDO::PARAM_STR);
            if ($query->execute()) {
                $user = $query->fetch(PDO::FETCH_ASSOC);
                if ($user === false) {
                    throw new Error(Error::INVALID_EMAIL);
                    return false;
                    exit();
                } else {
                    $query = $req->prepare('SELECT password FROM users WHERE email = :email');
                    $query->bindValue(':email', $email, \PDO::PARAM_STR);
                    $query->execute();
                    $user = $query->fetch(PDO::FETCH_ASSOC);
                    if (password_verify($password, $user['password'])) {
                        return true;
                    } else {
                        throw new Error(Error::INVALID_PASSWORD);
                        return false;
                    }
                }
            } else {
                return false;
                throw new Error(Error::ERROR_APPEND);
            }
        } catch (\Exception $e) {
            $errorMessage = $e->getMessage();
            echo $errorMessage;
            return false;
        }
    }

    protected function verifyRegisterInformations($lastName, $firstName, $email, $password, $confpass, $companions, $phoneNumber, $allergen): bool
    {
        try {

            if (empty($lastName) || empty($firstName) || empty($email) || empty($password) || empty($companions)) {
                throw new Error(Error::FORM_NOT_COMPLETE);
                return false;
            } else {
                // Ajouter vérification email (taille)
                if (strtolower($password) !== strtolower($confpass)) {
                    throw new Error(Error::PASSWORD_NOT_MATCH);
                    return false;
                } else {
                    if (strlen($password) < 8) {
                        throw new Error(Error::PASSWORD_TO_SHORT);
                        return false;
                    } else {
                        return true;
                    }
                }
            }
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }
}
