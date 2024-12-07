<?php 
require_once "auth.php"
?>


<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Gestion d'Ecole</title>

    
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.3.1/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
  </head>

<body>

<div class="sidebar">
    <div>
        <h4>Gestion d'Ecole</h4>
        <a href="dashboard.php" class="<?= basename($_SERVER['PHP_SELF']) == 'dashboard.php' ? 'active' : ''; ?>">
            <i class="bi bi-speedometer2"></i> Dashboard
        </a>
        <a href="parents.php" class="<?= basename($_SERVER['PHP_SELF']) == 'parents.php' ? 'active' : ''; ?>">
            <i class="bi bi-person-fill"></i> Parents
        </a>
        <a href="etudiants.php" class="<?= basename($_SERVER['PHP_SELF']) == 'etudiants.php' ? 'active' : ''; ?>">
            <i class="bi bi-person-fill"></i> Etudiants
        </a>
        <?php if ($auth_role == "directeur") : ?>
            <a href="secretaire.php" class="<?= basename($_SERVER['PHP_SELF']) == 'secretaire.php' ? 'active' : ''; ?>">
                <i class="bi bi-person-fill"></i> Secretaire
            </a>
        <?php endif; ?>
        <a href="classes.php" class="<?= basename($_SERVER['PHP_SELF']) == 'classes.php' ? 'active' : ''; ?>">
            <i class="bi bi-person-fill"></i> Classe
        </a>
    </div>

    <div class="user-info dropdown">
        <a href="#" class="d-block text-decoration-none text-white dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="bi bi-person-circle"></i>
            <strong>
                <?= $auth_username ?>
            </strong>
        </a>
        <ul class="dropdown-menu text-small">
            <li><a class="dropdown-item" href="logout.php">Logout</a></li>
        </ul>
    </div>
</div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>




    
