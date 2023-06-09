<?php
require_once _ROOTPATH_ . '/templates/header.php';

use App\Entity\Register;
use App\Db\FindIntoDb;

$allergen = new FindIntoDb;
$allergen->findAllAllergensIntoDb();

if (!empty($_POST)) {
    extract($_POST);
    if (isset($_POST['register'])) {
        $email = trim($email);
        $password = trim($password);
        $confpass = trim($confpass);
        $companions = (int)$companions;
        $phoneNumber = trim($phoneNumber);
        $allAllergen = implode(' , ', $allergens);
        $register = new Register;
        $register->registerUser($lastName, $firstName, $email, $password, $confpass, $companions, $phoneNumber, $allAllergen);
    }
}
var_dump($_SESSION);
if (isset($_SESSION['id'])) {
    header('Location : /');
}
?>

<div class="container">

    <?php
    if (isset($_POST['register'])) {
        if (property_exists('App\Entity\Register', 'err_passwordToShort')) {
            echo $register->getErrPasswordToShort();
        }
        if (property_exists('App\Entity\Register', 'err_formIncomplete')) {
            echo $register->getErrFormIncomplete();
        }
        if (property_exists('App\Entity\Register', 'err_emailAlreadyUse')) {
            echo $register->getErrEmailAlreadyUse();
        }
        if (property_exists('App\Entity\Register', 'err_confPassword')) {
            echo $register->getErrConfPassword();
        }
        if (property_exists('App\Entity\Register', 'err_dbConnect')) {
            echo $register->getErrDbConnect();
        }
        if (property_exists('App\Entity\Register', 'validateRegistration')) {
            echo $register->getvalidateRegistration();
        }
    } ?>

    <h1>Formulaire d'inscription</h1>
    <p>Les champs contenant un * sont obligatoires</p>
    <form method="POST" action="">
        <div class="input-group mb-2 mt-2">
            <span class="input-group-text">Nom et prénom*</span>
            <input type="text" class="form-control" value="" id="lastName" name="lastName" placeholder="Entrez votre nom" required pattern="[A-Za-zÀ-ÿ\-']{2,}">

            <input type="text" class="form-control" value="" id="firstName" name="firstName" placeholder="Entrez votre prénom" required pattern="[A-Za-zÀ-ÿ\-']{2,}">
        </div>

        <div class="form-group mb-2 mt-2">
            <label for="email">Adresse e-mail*</label>
            <input type="email" class="form-control" value="" id="email" name="email" placeholder="Entrez votre adresse e-mail" required pattern="^[A-Za-z]+@{1}[A-Za-z]{2,}$">
        </div>

        <div class="form-group mb-2 mt-2">
            <label for="password">Mot de passe*</label>
            <input type="password" class="form-control" value="" id="password" name="password" placeholder="Entrez votre mot de passe" required pattern="[A-Za-zÀ-ÿ\-']{8,}">
        </div>

        <div class="form-group mb-2 mt-2">
            <label for="confpass">Confirmez le mot de passe*</label>
            <input type="password" class="form-control" id="confpass" name="confpass" required placeholder="Entrez le même mot de passe qu'au dessus">
        </div>

        <div class="form-group mb-2 mt-2">
            <label for="companions">Accompagnants (chiffres uniquement)</label>
            <input type="text" class="form-control" id="companions" name="companions" placeholder="Notez ici le nombre d'accompagnants réguliers" pattern="[0-9]+>
        </div>

        <div class=" form-group mb-2 mt-2">
            <label for="allergen">Notez ici vos allergies</label>
            <div class='row'>
                <!-- foreach checkbox with class FindIntoDb -->
                <?php
                foreach ($allergen->getResult() as $id => $name) {
                    echo
                    "<div class='mt-1 mb-1 col-3'>
                    <input class='form-check-input' type='checkbox' id=checkbox_$id name='allergens[]' value='$name' >
                    <label for='checkbox_$id'>" . ucfirst($name) . "</label></div>";
                }
                ?>

            </div>
        </div>

        <div class="form-group">
            <label for="phoneNumber">Numéro de téléphone</label>
            <input type="tel" class="form-control" id="phoneNumber" name="phoneNumber" placeholder="format : xx-xx-xx-xx-xx" pattern="[0-9}{3}-[0-9}{3}-[0-9]{4}">
        </div>

        <button type="submit" name='register' class="btn btn-primary">S'inscrire</button>
    </form>
</div>
<?php require_once _ROOTPATH_ . '/templates/footer.php' ?>