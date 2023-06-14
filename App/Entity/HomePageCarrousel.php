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

        echo '<div id="carouselExampleCaptions" class="carousel slide">
            <div class="carousel-indicators">';
        foreach ($carrouselImages as $index => $image) {
            echo '<button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="' . $index . '"';
            echo ($index === 0) ? ' class="active" aria-current="true"' : '';
            echo ' aria-label="Slide ' . ($index + 1) . '"></button>';
        }
        echo '</div>
            <div class="carousel-inner">';
        foreach ($carrouselImages as $index => $image) {
            echo '<div class="carousel-item';
            echo ($index === 0) ? ' active' : '';
            echo '">
                <img src="' . $uploadsDirectory . $image . '" class="d-block presentationImg" alt="...">
                <div class="carousel-caption d-none d-md-block caption-bg">
                    <h5>' . $carrouselImageLabels[$index] . '</h5>
                    <p>' . $carrouselImageDescriptions[$index] . '</p>
                </div>
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
