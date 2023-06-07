<?php
require_once './templates/header.php';

use App\Repository\MenuRepository;
?>

<h1><?php
    $menuEntree = new MenuRepository();
    $menuEntree->findAllFoods('entree');  ?></h1>
<p>
</p>
<?php require_once './templates/footer.php' ?>