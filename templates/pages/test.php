<?php
require_once './templates/header.php';

use App\Repository\MenuRepository;
?>

<form action="" method="post">
    <label for='entree_select'>Choississez une nouvelle entrée à mettre au menu : </label>
    <br>
    <select name='entree' id='entree_select'>
        <?php
        $menuEntree = new MenuRepository();
        $menuEntree->findAllFoods('entree');  ?>
    </select>
    <label for='plat_select'>Choississez un nouveau plat à mettre au menu : </label>
    <br>
    <select name='plat' id='plat_select'>
        <?php
        $menuEntree = new MenuRepository();
        $menuEntree->findAllFoods('plat');  ?>
    </select>
    <input type="submit" value="Subscribe!">
</form>
<?php require_once './templates/footer.php' ?>