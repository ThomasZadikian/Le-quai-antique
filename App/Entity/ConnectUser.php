<?php

namespace App\Entity;

use App\Db\Mysql;
use Exception;
use PDO;
use App\Entity\User;
use App\Entity\Session;

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

    public function tryoToConnect(string $email, string $password)
    {
        if ($this->verifyConnectInformation($email, $password)) {
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
                            foreach ($user as $id => $value) {
                                Session::set("$id", $value);
                            }
                            if (Session::get('id')) {
                                $user = new User;
                                $user->defineUser();
                                unset($_GET['controller']);
                                header('Location: index.php');
                                exit();
                            } else {
                                throw new Error(Error::ERROR_APPEND);
                            }
                        } else {
                            throw new Error(Error::INVALID_PASSWORD);
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
}
