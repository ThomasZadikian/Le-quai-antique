<?php

namespace App\Entity;

class HomePageCarrousel
{
    private $config;

    public function __construct($config)
    {
        $this->config = $config;
    }

    public function displayCarrousel()
    {
        $uploadsDirectory = $this->config['uploadsDirectory'];
        $carrouselImages = $this->config['carrouselImages'];
        $carrouselImageLabels = $this->config['carrouselImageLabels'];
        $carrouselImageDescriptions = $this->config['carrouselImageDescriptions'];

        $totalImages = count($carrouselImages); // Nombre total d'images

        echo '<div id="carouselExampleCaptions" class="carousel slide">
        <div class="carousel-indicators">';
        for ($i = 0; $i < $totalImages; $i++) {
            echo '<button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="' . $i . '"';
            echo ($i === 0) ? ' class="active" aria-current="true"' : '';
            echo ' aria-label="Slide ' . ($i + 1) . '"></button>';
        }
        echo '</div>
        <div class="carousel-inner">';
        foreach ($carrouselImages as $index => $image) {
            echo '<div class="carousel-item';
            echo ($index === 0) ? ' active' : '';
            echo '">
                <img src="' . $uploadsDirectory . $image . '" class="d-block presentationImg" alt="' . $image . '">
                <div class="carousel-caption d-none d-md-block caption-bg">';
            if (isset($carrouselImageLabels[$index])) {
                echo '<h5>' . $carrouselImageLabels[$index] . '</h5>';
            }
            if (isset($carrouselImageDescriptions[$index])) {
                echo '<p>' . $carrouselImageDescriptions[$index] . '</p>';
                echo '<a href="index.php?controller=reservation"><button class="btn w-25 btn-dark" name="reservation" style="width: 50vh;">Réserver une table</button></a>';
            }
            echo '</div>
            </div>';
        }
        echo '</div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
</div>';
    }
}
