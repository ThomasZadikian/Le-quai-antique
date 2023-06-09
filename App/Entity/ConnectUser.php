<?php

namespace App\Entity;

use Exception;
use App\Db\Mysql;
use PDO;
use App\Controller;
use App\Controller\Controller as ControllerController;

class ConnectUser
{
    private function verifyConnectInformation(string $email, string $password): bool
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
                }
            } else {
            }
        } catch (\Exception $e) {
            $errorMessage = $e->getMessage();
            echo $errorMessage;
        }
    }

    public function tryoToConnect(string $email, string $password)
    {
        try {
            $db = Mysql::getInstance();
            $req = $db->getPDO();
            $query = $req->prepare('SELECT * from users WHERE email = :email');
            $query->bindValue(':email', $email, \PDO::PARAM_STR);
            if ($query->execute()) {
                $user = $query->fetch(PDO::FETCH_ASSOC);
                if ($user === false) {
                    throw new Error(Error::INVALID_EMAIL);
                } else {
                    if (password_verify($password, $user['password'])) {
                        // $date_connexion = date('Y-m-d H:i:s');
                        echo 'Connecté';
                        var_dump($user);
                        $_SESSION['id'] = $user['id'];
                        $_SESSION['email'] = $user['email'];
                        $_SESSION['lastName'] = $user['lastName'];
                        $_SESSION['firstName'] = $user['firstName'];
                        $_SESSION['phoneNumber'] = $user['phoneNumber'];
                        $_SESSION['dateInscription'] = $user['dateInscription'];
                        $_SESSION['role'] = $user['role'];
                        $_SESSION['allergen'] = $user['allergen'];
                        $_SESSION['companions'] = $user['companions'];
                        if ($_SESSION['id']) {
                            unset($_GET['controller']);
                            header('Location: index.php');
                            exit();
                        } else {
                            echo 'La connexion à échouée';
                        }
                    } else {
                        echo 'Le mot de passe ne correspond pas';
                    }
                }
            } else {
                throw new Error(Error::INVALID_EMAIL);
            }
        } catch (\Exception $e) {
            $errorMessage = $e->getMessage();
            echo $errorMessage;
        }
    }
}
