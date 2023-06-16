<?php

namespace App\Controller;

use App\Entity\Session;
use Exception;
use App\Entity\Error;
use App\Entity\Reservation;

class Controller
{
    public function route(): void
    {
        try {
            if (isset($_GET['controller'])) {
                switch ($_GET['controller']) {
                    case 'foodCard':
                        $this->render('pages/food_card_page');
                        break;
                    case 'home':
                        $homeController = new HomeController();
                        $homeController->home();
                        break;
                    case 'register':
                        $this->render('/pages/register_page');
                        break;
                    case 'connect':
                        $this->render('/pages/connect_page');
                        break;
                    case 'reservation':
                        $this->render('/pages/reservation_page');
                        break;
                    case 'pageManagement':
                        if (isset($_SESSION['role'])) {
                            switch ($_SESSION['role']) {
                                case 'admin':
                                    $pageManagement = new AdminController;
                                    $pageManagement->route();
                                    break;
                                case 'user':
                                    $pageManagement = new PageManagementController;
                                    $pageManagement->route();
                                    break;
                                default:
                                    $_GET['action'] = null;
                                    break;
                            }
                        }
                        break;
                    case 'disconnect':
                        Session::destroy();
                        break;
                    default:
                        throw new Error(Error::PAGES_NOT_FOUND);
                }
            } else {
                $homeController = new HomeController();
                $homeController->home();
            }
        } catch (Exception $e) {
            header("Refresh: 5; URL=index.php");
            echo $e->getMessage();
        }
    }

    protected function render(string $path, array $params = []): void
    {
        $filePath = _ROOTPATH_ . '/templates/' . $path . '.php';
        try {
            if (!file_exists($filePath)) {
                throw new Error(Error::PAGES_NOT_FOUND);
            } else {
                extract($params);
                require_once $filePath;
            }
        } catch (Exception $e) {
            header("Refresh: 5; URL=index.php");
            $this->render('/errors/defaultError', ['error' => $e->getMessage()]);
        }
    }
}
