<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="/assets/css/override-bootstrap.css">
    <title>Quai antique</title>
</head>

<body --bs-body-color>
    <header class="container-fluid">
        <nav class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-3 mb-4 border-bottom container">
            <p class="alert alert-danger"> Ceci est site d'exemple, merci de ne pas entrer d'informations personnelles</p>
            <?php
            if (isset($_SESSION['id'])) {
                echo "
                <ul class='nav col-12 col-md-auto mb-2 justify-content-center mb-md-0'>
                <li><a href='index.php?controller=home' class='nav-link px-2 link-secondary'>Home</a></li>
                <li><a href='index.php?controller=foodCard' class='nav-link px-2 link-secondary'>Carte du restaurant</a></li>               
            </ul>
            <div class='col-md-3 text-end'>
                <a href='index.php?controller=pageManagement&action=" . $_SESSION['role'] . "'><button type='button' class='btn btn-outline-primary me-2'>Gestion de compte</button></a>
                <a href='index.php?controller=disconnect'><button type='button' class='btn btn-outline-primary me-2'>Se déconnecter</button></a>
            </div>";
            } else {
                echo "
                <ul class='nav col-12 col-md-auto mb-2 justify-content-center mb-md-0'>
                <li><a href='index.php?controller=home' class='nav-link px-2 '><button type='button' class='btn btn-dark me-2'>Home</button></a></li>
                <li><a href='index.php?controller=foodCard' class='nav-link px-2 link-secondary'><button type='button' class='btn btn-dark me-2'>Carte du restaurant</button></a></li>  
            </ul>
            <div class='col-md-3 text-end'>
                <a href='index.php?controller=connect'><button type='button' class=' btn btn-dark me-2'>Me connecter</button></a>
            </div>";
            } ?>
        </nav>
    </header>
    <main class="container">