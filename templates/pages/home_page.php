<?php
require_once _ROOTPATH_ . '\templates\header.php';

use App\Controller\FoodController;
use App\Entity\HomePageCarrousel;
use App\Controller\ScheduleController;

$config = require_once _ROOTPATH_ . '/config.php';
$menuFood = new FoodController;
$homePageCarrousel = new HomePageCarrousel($config);
$scheduleController = new ScheduleController;
?>

<div class="container">
    <?= $homePageCarrousel->displayCarrousel();  ?>
</div>
<div class="container d-flex justify-content-center align-items-center">
    <a href="index.php?controller=reservation"><button class="btn btn-success" name="reservation" style="width: 100vh;">Réserver une table</button></a>
</div>
<div class="container text-center">
    <article class="row align-items-start">
        <!-- Card for menu midi -->
        <div class="card col-xxl-4" style="border: none;">
            <img src="../../uploads/example-04.jpg" class="card-img-top rounded mt-2 img-fluid" alt="..." style="object-fit: cover; height: 300px;">
            <div class="card-body">
                <h5 class="card-title">Menu midi</h5>
                <p class="card-text">Venez déguster notre magnifique menu de ce midi !</p>
            </div>
            <?= $menuFood->generateHomeMenu(1) ?>
            <div class="card-body">

            </div>
        </div>

        <!-- Card for menu soir -->
        <div class="card col-xxl-4" style="border: none;">
            <img src="../../uploads/example-05.jpg" class="card-img-top rounded mt-2 img-fluid" alt="..." style="object-fit: cover; height: 300px;">
            <div class="card-body">
                <h5 class="card-title">Menu soir</h5>
                <p class="card-text">Votre dîner de ce soir ? Il est indiqué juste en dessous.</p>
            </div>
            <?= $menuFood->generateHomeMenu(2) ?>
            <div class="card-body">
                <a href="#" class="card-link">Card link</a>
                <a href="#" class="card-link">Another link</a>
            </div>
        </div>
        <?= $scheduleController->displaySchedule() ?>
    </article>
</div>

<?php require_once _ROOTPATH_ . '\templates\footer.php' ?>