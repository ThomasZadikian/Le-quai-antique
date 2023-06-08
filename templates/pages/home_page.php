<?php require_once _ROOTPATH_ . '\templates\header.php'; ?>

<div class="container">
    <div id="carouselExampleCaptions" class="carousel slide">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="../../uploads/example-01.jpg" class="d-block presentationImg" alt="...">
                <div class="carousel-caption d-none d-md-block caption-bg">
                    <h5>First slide label</h5>
                    <p>Some representative placeholder content for the first slide.</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="../../uploads/example-02.jpg" class="d-block presentationImg" alt="...">
                <div class="carousel-caption d-none d-md-block caption-bg">
                    <h5>Second slide label</h5>
                    <p>Some representative placeholder content for the second slide.</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="../../uploads/example-03.jpg" class="d-block presentationImg" alt="...">
                <div class="carousel-caption d-none d-md-block caption-bg">
                    <h5>Third slide label</h5>
                    <p>Some representative placeholder content for the third slide.</p>
                </div>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
</div>

<div class="container text-center">
    <article class="row align-items-start">

        <!-- Card for horaires -->
        <div class="card col-xxl-4" style="border : none;">
            <div class="card-header">
                Horaires
            </div>
            <div class="card-header">
                <strong>Lundi - Vendredi</strong>
            </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item">Midi : xxh-xxh </li>
                <li class="list-group-item">Soir : xxh-xxh </li>
            </ul>
            <div class="card-header">
                <strong>Samedi</strong>
            </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item">Midi : xxh-xxh </li>
                <li class="list-group-item">Soir : xxh-xxh </li>
            </ul>
            <div class="card-header">
                <strong>Dimanche</strong>
            </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item">Midi : xxh-xxh </li>
                <li class="list-group-item">Soir : Fermé </li>
            </ul>
        </div>

        <!-- Card for menu midi -->
        <div class="card col-xxl-4" style="border : none;">
            <img src="../../uploads/example-04.jpg" class="card-img-top rounded mt-2" alt="...">
            <div class="card-body">
                <h5 class="card-title">Menu midi</h5>
                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
            </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item"><?= $entree ?></li>
                <li class="list-group-item">A second item</li>
                <li class="list-group-item">A third item</li>
            </ul>
            <div class="card-body">
                <a href="#" class="card-link">Card link</a>
                <a href="#" class="card-link">Another link</a>
            </div>
        </div>

        <!-- Card for menu soir -->
        <div class="card col-xxl-4" style="border : none;">
            <img src="../../uploads/example-05.jpg" class="card-img-top rounded mt-2" alt="...">
            <div class="card-body">
                <h5 class="card-title">Menu soir</h5>
                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
            </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item">An item</li>
                <li class="list-group-item">A second item</li>
                <li class="list-group-item">A third item</li>
            </ul>
            <div class="card-body">
                <a href="#" class="card-link">Card link</a>
                <a href="#" class="card-link">Another link</a>
            </div>
        </div>
    </article>
</div>

<?php require_once _ROOTPATH_ . '\templates\footer.php' ?>