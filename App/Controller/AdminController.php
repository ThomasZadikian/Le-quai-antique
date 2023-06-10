<?php

namespace App\Controller;

use Exception;

class AdminController extends Controller
{
    public function route(): void
    {
        try {
            if (isset($_GET['adminAction']) && $_SESSION['role'] === 'admin') {
                switch ($_GET['adminAction']) {
                    case 'food':
                        $this->render('pages/admin/admin_pageManagementFood');
                        break;
                    case 'planning':
                        $this->render('pages/admin/admin_pageManagementPlanning');
                        break;
                    case 'users':
                        $this->render('pages/admin/admin_pageManagementUsers');
                        break;
                }
            } else {
                if (isset($_GET['action'])   && $_GET['action'] === 'admin') {
                    $adminRoute = new PageManagementController();
                    $adminRoute->route();
                }
            }
        } catch (\Exception $e) {
        }
    }
}
