<?php
session_start();
require_once "db.php";

$error = '';

try {

    if ($_POST) {
        $username = $_POST['username'] ;
        $password = $_POST['password'] ;

        if (!empty($username) && !empty($password)) {
            
            $mot_de_passe = md5($password);

            $query = "SELECT * FROM users WHERE username = ? AND password = ?";
            $post = $db->prepare($query);
            $post->execute([$username, $mot_de_passe]);

            $user = $post->fetch();

            if ($user) {
                
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'];

                header("Location: dashboard.php");
                exit();
            } else {
                $error = "Nom d'utilisateur ou mot de passe incorrect.";
            }
        }
    }
} catch (PDOException $e) {
     $e->getMessage();
}
?>
 


<!doctype html>
<html lang="en" data-bs-theme="auto">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <title>Gestion d'Ecole</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css">

<body>
    <div class="login-form">

        <h2>Connexion</h2>
        <form action="login.php" method="POST">
            <div class="form-group position-relative">
                <label >Nom d'utilisateur</label>
                <input type="text" class="form-control"  name="username" required placeholder="Entrez votre nom d'utilisateur">
                <i class="fas fa-user"></i>
            </div>
            <div class="form-group position-relative">
                <label >Mot de passe</label>
                <input type="password" class="form-control"  name="password" required placeholder="Entrez votre mot de passe">
                <i class="fas fa-lock"></i> 
            </div>
            <div class="form-group">
                <button type="submit">Se connecter</button>
            </div>
        </form>

        <?php if (!empty($error)): ?>
            <div class="btn btn-danger">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>