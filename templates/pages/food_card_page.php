<?php
require_once _ROOTPATH_ . '/templates/header.php';

use App\Controller\FoodController;

$foodList = new FoodController;
$foodCard = $foodList->generateFoodCard();
?>
<h1>Carte du restaurant</h1>
<div class="container">
    <?= $foodCard; ?>
</div>
<?php require_once _ROOTPATH_ . '/templates/footer.php' ?>