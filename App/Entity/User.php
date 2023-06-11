<?php

namespace App\Entity;

use PDO;
use App\Db\Mysql;
use Exception;
use App\Entity\Session;

class User
{
    protected string $email;
    private string $password;
    protected string $lastName;
    protected string $firstName;
    protected int $companions;
    protected string $allergen;
    protected string $phoneNumber;
    protected string $registerDate;
    protected string $role;
    protected array $userData = [];

    public function defineUser()
    {
        if (isset($_SESSION['email'])) {
            $this->email = $_SESSION['email'];
        } else {
            $this->email = '';
        }
        if (isset($_SESSION['password'])) {
            $this->password = $_SESSION['password'];
        } else {
            $this->password = '';
        }
        if (isset($_SESSION['lastName'])) {
            $this->lastName = $_SESSION['lastName'];
        } else {
            $this->lastName = '';
        }
        if (isset($_SESSION['firstName'])) {
            $this->firstName = $_SESSION['firstName'];
        } else {
            $this->firstName = '';
        }
        if (isset($_SESSION['companions'])) {
            $this->companions = $_SESSION['companions'];
        } else {
            $this->companions = 0;
        }
        if (isset($_SESSION['allergen'])) {
            $this->allergen = $_SESSION['allergen'];
        } else {
            $this->allergen = '';
        }
        if (isset($_SESSION['phoneNumber'])) {
            $this->phoneNumber = $_SESSION['phoneNumber'];
        } else {
            $this->phoneNumber = '';
        }
        if (isset($_SESSION['registerDate'])) {
            $this->registerDate = $_SESSION['registerDate'];
        } else {
            $this->registerDate = '';
        }
        if (isset($_SESSION['role'])) {
            $this->role = $_SESSION['role'];
        } else {
            $this->role = 'user';
        }
    }
    public function getUserInformation(): array
    {
        foreach ($this as $attribute => $value) {
            if (!method_exists($this, $attribute)) {
                $this->userData[$attribute] = $value;
            }
        }
        return $this->userData;
    }

    public function changePassword($oldPassword, $newPassword)
    {
        try {
            $this->defineUser();
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
}
