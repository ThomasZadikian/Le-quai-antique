<?php

namespace App\Controller;

use Exception;

class ContactController extends Controller
{
    // public function route(): void
    // {
    //     try {
    //         if (isset($_GET['action'])) {
    //             $this->render('/templates/pages/contact', []);
    //         } else {
    //             throw new Exception('La page demandée n\'existe pas');
    //         }
    //     } catch (Exception $e) {
    //         $this->render('errors/defaultError', ['error' => $e->getmessage()]);
    //     }
    // }
    protected function contact()
    {
        $this->render('/pages/contact', []);
    }
}
