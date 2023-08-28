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
    <section class="col-xxl-5">
        <div class="accordion" id="accordionMenu">
            <div class="accordion-item text-white">
                <div class="card bg-dark mb-2">
                    <img src="../../uploads/example-04.jpg" class="card-img-top rounded" alt="..." style="object-fit: cover; height: 10vh;">
                    <h2 class="accordion-header ">
                        <button class="accordion-button bg-dark rounded text-white" type="button" data-bs-toggle="collapse" data-bs-target="#collapseMenuOne" aria-expanded="true" aria-controls="collapseMenuOne">
                            Le menu de ce midi
                        </button>
                    </h2>
                </div>
                <div id="collapseMenuOne" class="accordion-collapse collapse card-body" data-bs-parent="#accordionMenu">
                    <?= $menuFood->generateHomeMenu(1) ?>
                </div>
            </div>
            <div class="accordion-item text-white">
                <div class="card bg-dark mb-2">
                    <img src="../../uploads/example-05.jpg" class="card-img-top rounded img-fluid" alt="..." style="object-fit: cover; height: 10vh;">
                    <h2 class="accordion-header ">
                        <button class="accordion-button bg-dark rounded text-white" type="button" data-bs-toggle="collapse" data-bs-target="#collapseMenuTwo" aria-expanded="true" aria-controls="collapseMenuTwo">
                            Le menu de ce soir
                        </button>
                    </h2>
                </div>
                <div id="collapseMenuTwo" class="accordion-collapse collapse card-body" data-bs-parent="#accordionMenu">
                    <?= $menuFood->generateHomeMenu(2) ?>
                </div>
            </div>
        </div>
    </section>
    <section class="col-xxl-3"></section>
    <section class="col-xxl-4">
        <div class="accordion" id="accordionsSchedule">
            <div class="accordion-item text-white">
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