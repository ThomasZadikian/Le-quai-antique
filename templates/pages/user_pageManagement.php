<?php
require_once _ROOTPATH_ . '/templates/header.php';

use App\Entity\UserManagement\User_PageManagement;

$userPageManagement = new User_PageManagement;
$userInformation = $userPageManagement->getUserInformation();
$allAllergens = explode(', ', $userInformation['allergen']);

if (!empty($_POST)) {
    extract($_POST);
    if (isset($_POST['modifyPassword'])) {
        // $oldPassword = trim($oldPassword);
        $newPassword = trim($newPassword);
        $userPageManagement->changePassword($oldPassword, $newPassword);
    }
}

?>
<div class="container mt-5">
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <h2>Vos informations</h2>
            <ul class="list-group">
                <li class="list-group-item">
                    <strong>Nom:</strong> <?= ucfirst($userInformation['lastName']); ?>
                </li>
                <li class="list-group-item">
                    <strong>Prénom:</strong> <?= ucfirst($userInformation['firstName']); ?>
                </li>
                <li class="list-group-item">
                    <strong>Email:</strong> <?= $userInformation['email']; ?>
                </li>
                <li class="list-group-item">
                    <strong>Mot de passe:</strong> *****
                </li>
                <li class="list-group-item ms-2 me-2">
                    <form method="POST">
                        <div class="mb-3">
                            <label for="oldPassword" class="form-label">Ancien mot de passe</label>
                            <input type="password" class="form-control" id="oldPassword" name="oldPassword" required required pattern="[A-Za-zÀ-ÿ\-'0-9]{8,}">
                        </div>
                        <div class="mb-3">
                            <label for="newPassword" class="form-label">Nouveau mot de passe</label>
                            <input type="password" class="form-control" id="newPassword" name="newPassword" required required pattern="[A-Za-zÀ-ÿ\-'0-9]{8,}">
                        </div>
                        <button type="submit" name='modifyPassword' class="btn btn-primary">Modifier le mot de passe</button>
                    </form>
                </li>
                <li class="list-group-item">
                    <strong>Numéro de téléphone:</strong> <?= $userInformation['phoneNumber']; ?>
                </li>
                <li class="list-group-item">
                    <strong>Allergies:<br></strong>
                    <?php foreach ($allAllergens as $key => $value) {
                        echo '- ' . ucfirst($value) . '<br>';
                    } ?>
                </li>
                <li class="list-group-item">
                    <strong>Nombre de compagnons:</strong> <?= $userInformation['companions']; ?>
                </li>
            </ul>
        </div>
    </div>
</div>
<?php require_once _ROOTPATH_ . '/templates/footer.php' ?>