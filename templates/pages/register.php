<?php
require_once _ROOTPATH_ . '/templates/header.php';

use App\Entity\Register;

if (!empty($_POST)) {
    extract($_POST);
    if (isset($_POST['register'])) {
        $lastName = trim($lastName);
        $firstName = trim($firstName);
        $email = trim($email);
        $password = trim($password);
        $confpass = trim($confpass);
        $register = new Register;
        $register->registerUser($lastName, $firstName, $email, $password, $confpass);
    }
}

?>
<div class="container">
    <h1>Formulaire d'inscription</h1>
    <form method="POST" action="">
        <div class="mb-3">

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

            <label for="lastName">Nom*</label>
            <input type="text" class="form-control" value="<?php if (isset($lastName)) {
                                                                echo $lastName;
                                                            } ?>" id="lastName" name="lastName" placeholder="Entrez votre nom">
        </div>
        <div class="form-group">
            <label for="firstName">Prénom*</label>
            <input type="text" class="form-control" value="<?php if (isset($firstName)) {
                                                                echo $firstName;
                                                            } ?>" id="firstName" name="firstName" placeholder="Entrez votre prénom">
        </div>
        <div class="form-group">
            <label for="email">Adresse e-mail*</label>
            <input type="email" class="form-control" value="<?php if (isset($email)) {
                                                                echo $email;
                                                            } ?>" id="email" name="email" placeholder="Entrez votre adresse e-mail">
        </div>
        <div class="form-group">
            <label for="password">Mot de passe*</label>
            <input type="password" class="form-control" value="<?php if (isset($password)) {
                                                                    echo $password;
                                                                } ?>" id="password" name="password" placeholder="Entrez votre mot de passe">
        </div>
        <div class="form-group">
            <label for="confpass">Confirmez le mot de passe</label>
            <input type="password" class="form-control" id="confpass" name="confpass" placeholder="Confirmez votre mot de passe">
        </div>
        <button type="submit" name='register' class="btn btn-primary">S'inscrire</button>
    </form>
</div>
<?php require_once _ROOTPATH_ . '/templates/footer.php' ?>