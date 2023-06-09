<?php
require_once _ROOTPATH_ . '/templates/header.php';
$allAllergens = explode(', ', $_SESSION['allergens'])

?>
<div class="container mt-5">
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <h2>Vos informations</h2>
            <ul class="list-group">
                <li class="list-group-item">
                    <strong>Nom:</strong> <?= ucfirst($_SESSION['lastName']); ?>
                </li>
                <li class="list-group-item">
                    <strong>Prénom:</strong> <?= ucfirst($_SESSION['firstName']); ?>
                </li>
                <li class="list-group-item">
                    <strong>Email:</strong> <?= $_SESSION['email']; ?>
                </li>
                <li class="list-group-item">
                    <strong>Mot de passe:</strong> *****
                </li>
                <li class="list-group-item">
                    <strong>Numéro de téléphone:</strong> <?= $_SESSION['phoneNumber']; ?>
                </li>
                <li class="list-group-item">
                    <strong>Allergies:<br></strong> <?php foreach ($allAllergens as $key => $value) {
                                                        echo '- ' . ucfirst($value) . '<br>';
                                                    } ?>
                </li>
                <li class="list-group-item">
                    <strong>Nombre de compagnons:</strong> <?= $_SESSION['companions']; ?>
                </li>
            </ul>
        </div>
    </div>
</div>
<?php require_once _ROOTPATH_ . '/templates/footer.php' ?>