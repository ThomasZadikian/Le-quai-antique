<?php

namespace App\Entity\UserManagement;

use App\Db\Mysql;
use Exception;
use PDO;
use App\Entity\Session;

class ConnectUser extends User
{

    public function tryoToConnect(string $email, string $password)
    {
        if (parent::verifyConnectInformations($email, $password)) {
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
                                parent::setUserInformations();
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
