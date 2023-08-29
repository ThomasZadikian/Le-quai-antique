<?php
require_once _ROOTPATH_ . '/templates/header.php';

use App\Controller\FoodController;

$foodList = new FoodController;
$foodCard = $foodList->generateFoodCard();
?>
<section>
    <?= $foodCard; ?>
</section>
<?php require_once _ROOTPATH_ . '/templates/footer.php' ?>