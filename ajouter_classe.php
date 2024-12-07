<?php
require_once "auth.php";
require_once "db.php";

$error = '';

try {
   
    if ( ($_SESSION['role'] === 'secretaire' || $_SESSION['role'] === 'directeur')) {

        if (isset($_GET['id'])) {
            $id = $_GET['id'];

            $query = "SELECT * FROM classes WHERE id = ?";
            $post = $db->prepare($query);
            $post->execute([$id]);
            $classe = $post->fetch();

            if ($classe) {
                $filiere = $classe['filiere'];
                $niveau = $classe['niveau'];

            } 
            if ($_POST) {
                $filiere = $_POST['filiere'];
                $niveau = $_POST['niveau'];

                $query = "UPDATE classes SET filiere = ?, niveau = ? WHERE id = ?";
                $post = $db->prepare($query);
                $post->execute([$filiere, $niveau, $id]);

                $_SESSION['success_message'] = 'La Classe a été Modifier avec succès!';
                header("Location: classes.php");
                exit;
            }

        } else {

            if ($_POST) {
                $filiere = $_POST['filiere'];
                $niveau = $_POST['niveau'];

                $query = "INSERT INTO classes (filiere, niveau) VALUE (?, ?)";
                $post = $db->prepare($query);
                $post->execute([$filiere, $niveau]);

                $_SESSION['success_message'] = 'La Classe a été ajoutée avec succès!';
                header("Location: classes.php");
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
    $title = "Modifier une Classe";
} else {
    $title = "Ajouter une Classe";
}
?>


<?= navbar($title) ?>


<div class="form-container" style="margin-top: 10%">
    <h2 class="form-title"><?= $title ?></h2>

    <form method="post">
    
        <div class="col-md-9">
            <label for="filiere" class="form-label">Filière :</label>
            <input type="text" id="filiere" name="filiere" class="form-control" value="<?= isset($filiere) ? $filiere : ''; ?>" required>
        </div>
        
        <div class="col-md-9">
            <label for="niveau" class="form-label">Niveau :</label>
            <input type="text" id="niveau" name="niveau" class="form-control" value="<?= isset($niveau) ? $niveau : ''; ?>" required>
        </div>
        
        <button type="submit" class="btn btn-primary mt-4"><?= isset($id) ? "Mettre à jour" : "Enregistrer" ?></button>
        <a href="classes.php" class="btn btn-danger mt-4">Annuler</a>
    </form>
</div>
