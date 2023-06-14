<?php
require_once _ROOTPATH_ . '/templates/header.php';
//LOGIC FOR CONNEXION
use App\Entity\UserManagement\ConnectUser;

if (isset($_POST)) {
    extract($_POST);
    if (isset($_POST['connect'])) {
        $email = trim($email);
        $password = trim($password);
        $tryoToConnect = new ConnectUser;
        $tryoToConnect->tryoToConnect($email, $password);
    }
}

?>
<div class="container mt-5">
    <h2>Connexion</h2>
    <form action="" method="POST">
        <div class="form-group">
            <label for="email">Adresse mail :</label>
            <input type="text" class="form-control" id="email" name="email" placeholder="Nom d'utilisateur" required pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}">
        </div>
        <div class="form-group">
            <label for="password">Mot de passe :</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Mot de passe" required>
        </div>
        <button type="submit" class="btn btn-primary p-2 mt-1" name="connect">Se connecter</button>
    </form>
    <a href='index.php?controller=register'><button type='button' class='btn btn-primary me-2 mt-5'>Pas encore de compte ? </button></a>
</div>
<?php require_once _ROOTPATH_ . '/templates/footer.php' ?>