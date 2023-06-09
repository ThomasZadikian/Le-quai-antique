<?php

namespace App\Controller;

class PageManagementController extends Controller
{
    public function route(): void
    {
        if (isset($_GET['action'])) {
            switch ($_GET['action']) {
                case 'admin':
                    if (isset($_SESSION['id']) && $_SESSION['role'] === 'admin') {
                        $this->render('pages/admin_pageManagement');
                    } else {
                        header("Refresh: 5; URL=index.php");
                        echo 'Vous n\'êtes pas autorisé à venir sur cette page, vous allez être redirigé vers la page d\'accueil';
                    }
                    break;
                case 'user':
                    if (isset($_SESSION['id']) && $_SESSION['role'] === 'user') {
                        $this->render('pages/user_pageManagement');
                    } else {
                        header("Refresh: 5; URL=index.php");
                        echo 'Vous n\'êtes pas autorisé à venir sur cette page, vous allez être redirigé vers la page d\'accueil';
                    }
                    break;
                default:
                    header("Refresh: 5; URL=index.php");
                    echo 'Vous n\'êtes pas autorisé à venir sur cette page, vous allez être redirigé vers la page d\'accueil';
            }
        } else {
            header("Refresh: 5; URL=index.php");
            echo 'Vous n\'êtes pas autorisé à venir sur cette page, vous allez être redirigé vers la page d\'accueil';
        }
    }
}
