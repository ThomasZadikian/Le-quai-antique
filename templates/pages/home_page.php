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

<section>
    <?= $homePageCarrousel->displayCarrousel();  ?>
</section>
<article class="row row-col-12 mt-2">
    <section class="col-xxl-6">
        <div class="accordion accordion-flush" id="accordionMenu">
            <div class="accordion-item mb-2 rounded">
                <h2 class="accordion-header ">
                    <button class="accordion-button bg-dark rounded text-white d-flex flex-column" type="button" data-bs-toggle="collapse" data-bs-target="#collapseMenu1" aria-expanded="true" aria-controls="collapseMenu1">
                        <img src=" ../../uploads/example-04.jpg" class="card-img-top rounded mb-2" alt="..." style="object-fit: cover; height: 10vh;">
                        Le menu de ce midi
                    </button>
                </h2>
                <div class="accordion-collapse show" id="collapseMenu1" data-bs-parent="#collapseMenu1">
                    <div class="card-body">
                        <?= $menuFood->generateHomeMenu(1) ?>
                    </div>
                </div>
            </div>
            <div class="accordion-item rounded">
                <h2 class="accordion-header">
                    <button class="accordion-button bg-dark rounded text-white d-flex flex-column" type="button" data-bs-toggle="collapse" data-bs-target="#collapseMenu2" aria-expanded="true" aria-controls="collapseMenu2">
                        <img src=" ../../uploads/example-05.jpg" class="card-img-top rounded mb-2" alt="..." style="object-fit: cover; height: 10vh;">
                        Le menu de ce soir
                    </button>
                </h2>
                <div class="accordion-collapse show" id="collapseMenu2" data-bs-parent="#collapseMenu2">
                    <div class="card-body">
                        <?= $menuFood->generateHomeMenu(2) ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="col-xxl-2"></section>
    <section class="col-xxl-4">
        <div class="accordion" id="accordionsSchedule">
            <div class="accordion-item text-white border  border-0">
                <h2 class="accordion-header">
                    <button class="accordion-button bg-dark rounded text-white" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSchedule" aria-expanded="true" aria-controls="collapseSchedule">
                        Afficher les horaires
                    </button>
                </h2>
                <div id="collapseSchedule" class="accordion-collapse collapse show card-body" data-bs-parent="#accordionsSchedule">
                    <?= $scheduleController->displaySchedule() ?>
                </div>
            </div>
        </div>
    </section>
</article>

<?php require_once _ROOTPATH_ . '\templates\footer.php' ?>