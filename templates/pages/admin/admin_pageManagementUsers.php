<?php
require_once _ROOTPATH_ . '/templates/header.php';
require_once _ROOTPATH_ . '/templates/adminPanel.php';

use App\Db\FindIntoDb;
use App\Entity\CreatedFood;

$searchInDb = new FindIntoDb;
?>
<div class="container">
    <form>
        <div class="mb-3 mt-5">
            <select multiple class="form-select" id="utilisateurs">
                <?php
                foreach ($searchInDb->getUsers() as $key => $value) {
                    echo "<option value=" . $value . ">" . $value . "</option>";
                }
                ?>
            </select>
        </div>
        <!-- <button type="submit" class="btn btn-danger">Supprimer</button> -->
    </form>
</div>
<?php require_once _ROOTPATH_ . '/templates/footer.php' ?>