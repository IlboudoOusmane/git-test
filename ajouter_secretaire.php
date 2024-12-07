<?php
require_once "auth.php";
require_once "db.php";

$error = '';

try {

    if ($_SESSION['role'] === 'directeur') {

        if (isset($_GET['id'])) {
            $id = $_GET['id'];

            $query = "SELECT * FROM users WHERE id = ?";
            $post = $db->prepare($query);
            $post->execute([$id]);
            $user = $post->fetch();

            if ($user) {
                $username = $user['username'];
                $role = $user['role'];
            }

            if ($_POST) {
                $username = $_POST['username'];
                $password = $_POST['password'];
                $role = $_POST['role'];

                if (!empty($password)) {
                    $Password = md5($password);
                } else {

                    $Password = $user['password'];
                }


                $query = "UPDATE users SET username = ?, password = ?, role = ? WHERE id = ?";
                $post = $db->prepare($query);
                $post->execute([$username, $Password, $role, $id]);

                $_SESSION['success_message'] = 'L\'utilisateur a été Modier avec succès!';
                header("Location: secretaire.php");
                exit;
            }

        } else {
            
            if ($_POST) {
                $username = $_POST['username'];
                $password = $_POST['password'];
                $role = $_POST['role'];

                $Password = md5($password);

                $query = "SELECT * FROM users WHERE username = ?";
                $post = $db->prepare($query);
                $post->execute([$username]);
                $user = $post->fetch();

                if ($user) {
                    $_SESSION['error_message'] = 'Le nom d\'utilisateur existe déjà.';
                    header("Location: ajouter_secretaire.php");
                    exit();
                }

                $query = "INSERT INTO users (username, password, role) VALUE (?, ?, ?)";
                $post = $db->prepare($query);
                $post->execute([$username, $Password, $role]);

                $_SESSION['success_message'] = 'La secrétaire a été ajoutée avec succès!';
                header("Location: secretaire.php");
                exit();
            }
        }

    } else {
        header("Location: login.php");
        exit();
    }

} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

require "header.php";
require "navbar.php";

if (isset($id)) {
    $title = "Modifier une Secretaire";
} else {
    $title = "Ajouter une Secretaire";
}

?>


<?= navbar($title) ?>


<div class="form-container" style="margin-top: 10%">
    <h2 class="form-title"><?= $title ?></h2>
 

    <form method="post">
        <div class="col-md-9">
            <label for="username" class="form-label">Nom d'Utilisateur :</label>
            <input type="text" id="username" name="username" class="form-control" value="<?= isset($username) ? $username : ''; ?>" required>
        </div>

        <?php if (!isset($id)): ?>
        <div class="col-md-9">
            <label for="password" class="form-label">Mot de Passe :</label>
            <input type="password" id="password" name="password" class="form-control" required>
        </div>
        <?php endif; ?>

        <div class="col-md-9">
            <label for="role" class="form-label">Rôle :</label>
            <select name="role" class="form-select" required>
                <option value="secretaire" <?= isset($role) && $role == 'secretaire' ? 'selected' : ''; ?>>Secrétaire</option>
                <option value="directeur" <?= isset($role) && $role == 'directeur' ? 'selected' : ''; ?>>Directeur</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary mt-4"><?= isset($id) ? "Mettre à jour" : "Enregistrer" ?></button>
        <a href="secretaire.php" class="btn btn-danger mt-4">Annuler</a>
    </form>
</div>


