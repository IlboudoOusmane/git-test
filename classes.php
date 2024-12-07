<?php
require_once "auth.php";
require_once "db.php";

try {
    
    if (isset($_GET['delete'])) {
        
        $classe_id = $_GET['delete'];
        $query = "DELETE FROM classes WHERE id = ?";
        $post = $db->prepare($query);
        $post->execute([$classe_id]);
        
        $_SESSION['success_message'] = "La Classe a été supprimé avec succès!";
        
        header("Location: classes.php");
        exit();
    }


$query = "SELECT * FROM classes";
$post = $db->prepare($query);
$post->execute();

$classes = $post->fetchAll();


} catch (PDOException $e) {
    $e->getMessage();
    exit();
}
 
require_once "header.php"

?>


<nav class="navbar navbar-dark bg-dark" style="margin-left: 18%;"> 
    <div class="container-fluid">
      <div class="mx-auto text-white navbar-text">
        <h3>Liste des Classes</h3>
      </div>
      <a href="ajouter_classe.php" class="btn btn-primary" style="float: right">
        <i class="bi bi-plus-lg"></i> Classes
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
      <?php if (count($classes) > 0): ?>
        <thead>
            <tr>
                <th>ID</th>
                <th>Filière</th>
                <th>Niveau</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($classes as $classe) : ?>
                <tr>
                    <td><?= $classe['id']; ?></td>
                    <td><?= $classe['filiere']; ?></td>
                    <td><?= $classe['niveau']; ?></td>
                    <td>
                        <a href="ajouter_classe.php?id=<?= $classe['id'] ?>" class="btn btn-warning ">Modifier</a>
                    <?php if($auth_role == "directeur") : ?>
                        <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal<?= $classe['id'] ?>">Supprimer</button>

                        <div class="modal fade" id="deleteModal<?= $classe['id'] ?>" tabindex="-1" aria-labelledby="deleteModalLabel<?= $classe['id'] ?>" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="deleteModalLabel<?= $classe['id']; ?>">Confirmer la suppression</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        Êtes-vous sûr de vouloir supprimer la classe <?= $classe['filiere'] ?> <?= $classe['niveau']; ?> ?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                        <a href="classes.php?delete=<?= $classe['id'] ?>" class="btn btn-danger">Supprimer</a>
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
                    Aucune Classe ajoutée
            </th>
              </tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>

<div class="mt-4 text-center">
    <p>
        <?php if (count($classes) > 0): ?>
            Il y a <?= count($classes) ?> Classe<?= count($classes)  > 1 ? 's' : '' ?> Ajoutée<?= count($classes)  > 1 ? 's' : '' ?>
        <?php endif; ?>
        </p>
</div>