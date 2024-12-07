<?php
require_once "auth.php";
require_once "db.php";

try {
    
    if (isset($_GET['delete'])) {
        
        $parent_id = $_GET['delete'];
        $query = "DELETE FROM parents WHERE id = ?";
        $post = $db->prepare($query);
        $post->execute([$parent_id]);
        
        $_SESSION['success_message'] = "Le Parent a été supprimé avec succès!";
        
        header("Location: parents.php");
        exit();
        
    }
    
$query = "SELECT * FROM parents";
$post = $db->prepare($query);
$post->execute();

$parents = $post->fetchAll();


} catch (PDOException $e) {
    $e->getMessage();
    exit();
}
 
require_once "header.php"

?>


<nav class="navbar navbar-dark bg-dark" style="margin-left: 18%;"> 
    <div class="container-fluid">
      <div class="mx-auto text-white navbar-text">
        <h3>Liste des Parents</h3>
      </div>
      <a href="ajouter_parent.php" class="btn btn-primary" style="float: right">
        <i class="bi bi-plus-lg"></i> Parents
    </a>
    </div>
</nav>

<div style=" margin-left:20%; margin-right:3%" class="mt-5">

<?php if (isset($_SESSION['success_message'])) : ?>
    <div class="alert alert-success" >
        <?= $_SESSION['success_message'] ?>
    </div> 
    <?php unset($_SESSION['success_message']); ?>
 <?php endif; ?> 

<table class="table table-striped">
    <?php if (count($parents) > 0): ?>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Numéro de Téléphone</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($parents as $parent) : ?>
                <tr>
                    <td><?= $parent['id']; ?></td>
                    <td><?= $parent['nom']; ?></td>
                    <td><?= $parent['prenom']; ?></td>
                    <td><?= $parent['numero']; ?></td>

                    <td>
                        <a href="ajouter_parent.php?id=<?= $parent['id'] ?>" class="btn btn-warning ">Modifier</a>
                    <?php if($auth_role == "directeur") : ?>
                        <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal<?= $parent['id']; ?>">Supprimer</button>

                        <div class="modal fade" id="deleteModal<?= $parent['id']; ?>" tabindex="-1" aria-labelledby="deleteModalLabel<?= $parent['id']; ?>" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="deleteModalLabel<?= $parent['id']; ?>">Confirmer la suppression</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        Êtes-vous sûr de vouloir supprimer le parent <?= $parent['nom']; ?> <?= $parent['prenom']; ?> ?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                        <a href="parents.php?delete=<?= $parent['id']; ?>" class="btn btn-danger">Supprimer</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php else :?>
              <tr>
                <th class="text-center" style="font-size: 18px; color: black;">
                    Aucun Parent ajoutée
            </th>
              </tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>


<div class="mt-4 text-center">
    <p>
        <?php if (count($parents) > 0): ?>
            Il y a <?= count($parents) ?> Parent<?= count($parents) > 1 ? 's' : '' ?> Ajouté<?= count($parents) > 1 ? 's' : '' ?>
        <?php endif; ?>
        </p>
</div>
