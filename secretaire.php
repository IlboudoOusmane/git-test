<?php 
require_once "auth.php";
require_once "db.php";

try {

    if (isset($_GET['delete'])) {
        
        $user_id = $_GET['delete'];
        $query = "DELETE FROM users WHERE id = ?";
        $post = $db->prepare($query);
        $post->execute([$user_id]);
        
        $_SESSION['success_message'] = "La Sécrétaire a été supprimé avec succès!";
        
        header("Location: secretaire.php");
        exit();
    }
    
$query = "SELECT * FROM users WHERE id > 1 ";
$post = $db->prepare($query);
$post->execute();

$utilisateurs = $post->fetchAll();


} catch (PDOException $e) {
    $e->getMessage();
    exit();
}

require_once "header.php"
?>

<nav class="navbar navbar-dark bg-dark" style="margin-left: 18%;"> 
    <div class="container-fluid">
      <div class="mx-auto text-white navbar-text">
        <h3>Liste des Sécrétaires</h3>
      </div>
      <a href="ajouter_secretaire.php" class="btn btn-primary" style="float: right">
        <i class="bi bi-plus-lg"></i> Secretaire
    </a>
    </div>
</nav>

     

<div style=" margin-left:20%; margin-top:10%; margin-right:3%" class="mt-5">

<?php if (isset($_SESSION['success_message'])) : ?>
    <div class="alert alert-success" >
        <?= $_SESSION['success_message'] ?>
    </div> 
    <?php unset($_SESSION['success_message']); ?>
 <?php endif; ?> 

<table class="table table-striped">
    <?php if (count($utilisateurs) > 0): ?>
        <thead>
            <tr>
                <th>ID</th>
                <th>NOM</th>
                <th>Role</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($utilisateurs as $utilisateur) : ?>
                <tr>
                    <td><?= $utilisateur['id']; ?></td>
                    <td><?= $utilisateur['username']; ?></td>
                    <td><?= $utilisateur['role']; ?></td>

                    <td>
                        <a href="ajouter_secretaire.php?id=<?= $utilisateur['id'] ?>" class="btn btn-warning ">Modifier</a>
                        <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal<?= $utilisateur['id']; ?>">Supprimer</button>

                        <div class="modal fade" id="deleteModal<?= $utilisateur['id']; ?>" tabindex="-1" aria-labelledby="deleteModalLabel<?= $utilisateur['id']; ?>" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="deleteModalLabel<?= $utilisateur['id']; ?>">Confirmer la suppression</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        Êtes-vous sûr de vouloir supprimer la Sécretaire <?= $utilisateur['username']; ?> ?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                        <a href="secretaire.php?delete=<?= $utilisateur['id']; ?>" class="btn btn-danger">Supprimer</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php else :?>
              <tr>
                <th class="text-center" style="font-size: 18px; color: black;">
                    Aucune Sécrétaire ajoutée
            </th>
              </tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>



<div class="mt-4 text-center">
    <p>
        <?php if (count($utilisateurs) > 0): ?>
            Il y a <?= count($utilisateurs) ?> Sécrétaire<?= count($utilisateurs) > 1 ? 's' : '' ?> Ajoutée<?=count($utilisateurs) > 1 ? 's' : '' ?>
        <?php endif; ?>
        </p>
</div>