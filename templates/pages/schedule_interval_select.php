<?php
$timeInterval = json_decode($_POST['jsonData'], true);
?>

<div class="container">
    <div class="row">
        <div class="col-6 mt-3 mb-3"> Horaires du midi :
            <form method="GET">
                <select class="form-control" name="launchTime">
                    <?php foreach ($timeInterval['launch'] as $value) {
                        echo '<option value="' . $value . '">' . $value . '</option>';
                    } ?>
                </select>
                <button name="validateLaunch" class="btn btn-success">Réserver un midi</button>
            </form>
        </div>
        <div class="col-6 mt-3 mb-3"> Horaires du soir :
            <form method="GET">
                <select class="form-control" name="dinnerTime">
                    <?php foreach ($timeInterval['dinner'] as $value) {
                        echo '<option name="dinnerTime' . $value . '" value="' . $value . '">' . $value . '</option>';
                    } ?>
                </select>
                <button name="validateDinner" class="btn btn-success">Réserver un soir</button>
            </form>
        </div>
    </div>
</div>