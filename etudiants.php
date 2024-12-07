<?php 
require_once "auth.php";
require_once "db.php";

try {

    if (isset($_GET['delete'])) {
        
        $etudiant_id = $_GET['delete'];
        $query = "DELETE FROM etudiants WHERE id = ?";
        $post = $db->prepare($query);
        $post->execute([$etudiant_id]);

        $_SESSION['success_message'] = "L'Etudiants a été supprimé avec succès!";
        
        header("Location: etudiants.php");
        exit();
        
    }

    
$query = "SELECT e.id, e.nom, e.prenom, e.date_naissance, e.ville, c.filiere, c.niveau, p.nom as parent_nom, p.prenom as parent_prenom
        FROM etudiants e
        JOIN classes c ON e.classe_id = c.id
        JOIN parents p ON e.parent_id = p.id";

$post = $db->prepare($query);
$post->execute();

$etudiants = $post->fetchAll();




} catch (PDOException $e) {
    $e->getMessage();
    exit();
}

require_once "header.php"
?>



<nav class="navbar navbar-dark bg-dark " style="margin-left: 18%;"> 
    <div class="container-fluid">
      <div class="mx-auto text-white navbar-text">
        <h3>Liste des Etudiants</h3>
      </div>
      <a href="ajouter_etudiant.php" class="btn btn-primary" style="float: right">
        <i class="bi bi-plus-lg"></i> Etudiants
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
    <?php if (count($etudiants) > 0): ?>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Date de naissance</th>
                <th>Ville</th>
                <th>Classe</th>
                <th>Parent</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($etudiants as $etudiant) : ?>
                <tr>
                    <td><?= $etudiant['id'] ?></td>
                    <td><?= $etudiant['nom'] ?></td>
                    <td><?= $etudiant['prenom'] ?></td>
                    <td><?= $etudiant['date_naissance'] ?></td>
                    <td><?= $etudiant['ville'] ?></td>
                    <td><?= $etudiant['filiere'] . " - " . $etudiant['niveau'] ?></td>
                    <td><?= $etudiant['parent_nom'] . " " . $etudiant['parent_prenom']; ?></td>

                    <td>
                        <a href="ajouter_etudiant.php?id=<?= $etudiant['id'] ?>" class="btn btn-warning ">Modifier</a>
                    <?php if($auth_role == "directeur") : ?>
                        <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal<?= $etudiant['id']; ?>">Supprimer</button>

                        <div class="modal fade" id="deleteModal<?= $etudiant['id']; ?>" tabindex="-1" aria-labelledby="deleteModalLabel<?= $etudiant['id']; ?>" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="deleteModalLabel<?= $etudiant['id']; ?>">Confirmer la suppression</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        Êtes-vous sûr de vouloir supprimer l' Etudiant <?= $etudiant['nom'] ?><?= $etudiant['prenom'] ?>  ?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                        <a href="etudiants.php?delete=<?= $etudiant['id']; ?>" class="btn btn-danger">Supprimer</a>
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
                    Aucun Etudiant ajoutée
            </th>
              </tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>


<div class="mt-4 text-center">
    <p>
        <?php if (count($etudiants) > 0): ?>
            Il y a <?= count($etudiants) ?> étudiant<?= count($etudiants) > 1 ? 's' : '' ?> inscrit<?= count($etudiants) > 1 ? 's' : '' ?>
        <?php endif; ?>
        </p>
</div>