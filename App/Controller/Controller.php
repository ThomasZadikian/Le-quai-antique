<?php

namespace App\Controller;

use Exception;

class Controller
{
    public function route(): void
    {
        try {
            if (isset($_GET['controller'])) {
                switch ($_GET['controller']) {
                    case 'contact':
                        // Charger page de contact
                        break;
                    default:
                        throw new Exception('La page demandé n\'existe pas');
                        // Création d'une nouvelle erreur
                }
            } else {
                $homeController = new HomeController();
                $homeController->home();
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    protected function render(string $path, array $params = []): void
    {
        $filePath = _ROOTPATH_ . '/templates/' . $path . '.php';
        try {
            if (!file_exists($filePath)) {
                throw new Exception('Fichier non trouvé : ' . $filePath);
            } else {
                extract($params);
                require_once $filePath;
            }
        } catch (Exception $e) {
            $this->render('/errors/default', ['error' => $e->getMessage()]);
        }
    }
}
