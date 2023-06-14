<?php require_once _ROOTPATH_ . '/templates/header.php'; ?>

<nav class="navbar navbar-expand-lg bg-body-tertiary rounded" aria-label="Thirteenth navbar example">
  <div class="container-fluid">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExample11" aria-controls="navbarsExample11" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse d-lg-flex" id="navbarsExample11">
      <a class="navbar-brand col-lg-3 me-0" href="#">Page d'administration</a>
      <ul class="navbar-nav col-lg-6 justify-content-lg-center">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="index.php?controller=pageManagement&action=admin&adminAction=food">Gestionnaires des plats</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="index.php?controller=pageManagement&action=admin&adminAction=planning">Horaires du restaurants et planning</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="index.php?controller=pageManagement&action=admin&adminAction=users">Modifier les images de l'accueil</a></a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<?php require_once _ROOTPATH_ . '/templates/header.php'; ?>