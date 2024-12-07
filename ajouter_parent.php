<?php
require_once "auth.php";
require_once "db.php";

try {

    if ($_SESSION['role'] === 'secretaire' || $_SESSION['role'] === 'directeur') {
        
        if (isset($_GET['id'])) {
            $id = $_GET['id'];

           
            $query = "SELECT * FROM parents WHERE id = ?";
            $post = $db->prepare($query);
            $post->execute([$id]);
            $parent = $post->fetch();

            if ($parent) {
                $nom = $parent['nom'];
                $prenom = $parent['prenom'];
                $numero = $parent['numero'];
            }


            if ($_POST) {
                
                $nom = $_POST['nom'];
                $prenom = $_POST['prenom'];
                $numero = $_POST['numero'];

                $query = "UPDATE parents SET nom = ?, prenom = ?, numero = ? WHERE id = ?";
                $post = $db->prepare($query);
                $post->execute([$nom, $prenom, $numero, $id]);

                $_SESSION['success_message'] = 'Le Parent a été modifié avec succès!';
                header("Location: parents.php");
                exit;
            }

        } else {

            if ($_POST) {
                $nom = $_POST['nom'];
                $prenom = $_POST['prenom'];
                $numero = $_POST['numero'];

                $query = "INSERT INTO parents (nom, prenom, numero) VALUE (?, ?, ?)";
                $post = $db->prepare($query);
                $post->execute([$nom, $prenom, $numero]);

                $_SESSION['success_message'] = 'Le Parent a été ajouté avec succès!';
                header("Location: parents.php");
                exit;
            }
        }

    } else {
        header("Location: login.php");
        exit;
    }
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

require "header.php";
require "navbar.php";

if (isset($id)) {
    $title = "Modifier un Parent";
} else {
    $title = "Ajouter un Parent";
}
?>


<?= navbar($title) ?>


<div class="form-container" style="margin-top: 10%">
    <h2 class="form-title"><?= $title ?></h2>


    <?php
    if (isset($_SESSION['error_message'])) {
        echo '<div class="alert alert-danger">' . $_SESSION['error_message'] . '</div>';
        unset($_SESSION['error_message']);
    }

    if (isset($_SESSION['success_message'])) {
        echo '<div class="alert alert-success">' . $_SESSION['success_message'] . '</div>';
        unset($_SESSION['success_message']);
    }
    ?>

    <form method="post">
        <div class="col-md-9">
            <label for="nom" class="form-label">Nom :</label>
            <input type="text" id="nom" name="nom" class="form-control" value="<?= isset($nom) ? $nom : ''; ?>" required>
        </div>

        <div class="col-md-9">
            <label for="prenom" class="form-label">Prénom :</label>
            <input type="text" id="prenom" name="prenom" class="form-control" value="<?= isset($prenom) ? $prenom : ''; ?>" required>
        </div>

        <div class="col-md-9">
            <label for="numero" class="form-label">Contacts :</label>
            <input type="text" id="numero" name="numero" class="form-control" value="<?= isset($numero) ? $numero : ''; ?>" required>
        </div>

        <button type="submit" class="btn btn-primary mt-4"><?= isset($id) ? "Mettre à jour" : "Enregistrer"; ?></button>
        <a href="parents.php" class="btn btn-danger mt-4">Annuler</a>
    </form>
</div>


