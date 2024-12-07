<?php
require_once "auth.php";
require_once "db.php";

try {

    if ($_SESSION['role'] === 'secretaire' || $_SESSION['role'] === 'directeur') {

        if (isset($_GET['id'])) {

            $id = $_GET['id'];

            $query = "SELECT * FROM etudiants WHERE id = ?";
            $post = $db->prepare($query);
            $post->execute([$id]);
            $etudiant = $post->fetch();


            if ($etudiant) {

                $nom = $etudiant['nom'];
                $prenom = $etudiant['prenom'];
                $date_naissance = $etudiant['date_naissance'];
                $ville = $etudiant['ville'];
                $classe_id = $etudiant['classe_id'];
                $parent_id = $etudiant['parent_id'];
            } 

            if ($_POST) {

                $nom = $_POST['nom'];
                $prenom = $_POST['prenom'];
                $date_naissance = $_POST['date_naissance'];
                $ville = $_POST['ville'];
                $classe_id = $_POST['classe_id'];
                $parent_id = $_POST['parent_id'];

                $query = "UPDATE etudiants SET nom = ?, prenom = ?, date_naissance = ?, ville = ?, parent_id = ?, classe_id = ? WHERE id = ?";
                $post = $db->prepare($query);
                $post->execute([$nom, $prenom, $date_naissance, $ville, $parent_id, $classe_id, $id]);

                $_SESSION['success_message'] = "L'Étudiant a été modifié avec succès!";
                header("Location: etudiants.php");
                exit;
            }

        } else {

            if ($_POST) {
                $nom = $_POST['nom'];
                $prenom = $_POST['prenom'];
                $date_naissance = $_POST['date_naissance'];
                $ville = $_POST['ville'];
                $classe_id = $_POST['classe_id'];
                $parent_id = $_POST['parent_id'];

                $query = "INSERT INTO etudiants (nom, prenom, date_naissance, ville, parent_id, classe_id)
                          VALUES (?, ?, ?, ?, ?, ?)";
                $post = $db->prepare($query);
                $post->execute([$nom, $prenom, $date_naissance, $ville, $parent_id, $classe_id]);

                $_SESSION['success_message'] = "L'Étudiant a été ajouté avec succès!";
                header("Location: etudiants.php");
                exit;
            }
        }


        $query = "SELECT p.id, p.nom, p.prenom FROM parents p";
        $post = $db->prepare($query);
        $post->execute();
        $parents = $post->fetchAll();

        $query = "SELECT c.id, c.filiere, c.niveau FROM classes c";
        $post = $db->prepare($query);
        $post->execute();
        $classes = $post->fetchAll();

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
    $title = "Modifier un Etudiant";
} else {
    $title = "Ajouter un Etudiant";
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
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="nom" class="form-label">Nom :</label>
                <input type="text" id="nom" name="nom" class="form-control" value="<?= isset($nom) ? $nom : ''; ?>" required>
            </div>
            <div class="col-md-6">
                <label for="prenom" class="form-label">Prénom :</label>
                <input type="text" id="prenom" name="prenom" class="form-control" value="<?= isset($prenom) ? $prenom : ''; ?>" required>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label for="date_naissance" class="form-label">Date de naissance :</label>
                <input type="date" id="date_naissance" name="date_naissance" class="form-control" value="<?= isset($date_naissance) ? $date_naissance : ''; ?>" required>
            </div>
            <div class="col-md-6">
                <label for="ville" class="form-label">Ville :</label>
                <input type="text" id="ville" name="ville" class="form-control" value="<?= isset($ville) ? $ville : ''; ?>" required>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label for="classe" class="form-label">Classe :</label>
                <select name="classe_id" id="classe_id" class="form-select" required>
                    <?php foreach ($classes as $classe): ?>
                        <option value="<?= $classe['id'] ?>" <?= isset($classe_id) && $classe_id == $classe['id'] ? 'selected' : ''; ?>>
                            <?= $classe['filiere'] . " " . $classe['niveau'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="col-md-6">
                <label for="parent_id" class="form-label">Parent :</label>
                <select name="parent_id" id="parent_id" class="form-select" required>
                    <?php foreach ($parents as $parent): ?>
                        <option value="<?= $parent['id'] ?>" <?= isset($parent_id) && $parent_id == $parent['id'] ? 'selected' : ''; ?>>
                            <?= $parent['nom'] . " " . $parent['prenom'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <button type="submit" class="btn btn-primary"><?= isset($id) ? "Mettre à jour" : "Enregistrer" ?></button>
        <a href="etudiants.php" class="btn btn-danger">Annuler</a>
    </form>
</div>


