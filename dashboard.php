<?php 
require_once "auth.php";
require_once "db.php";

try {

    $query = "SELECT COUNT(*) AS total FROM etudiants ";
    $post = $db->prepare($query);
    $post->execute();
    $etudiants = $post->fetchAll();
    $total_etudiant = $etudiants['0']['total'];
    

    $query = "SELECT COUNT(*) AS total FROM parents ";
    $post = $db->prepare($query);
    $post->execute();
    $parents = $post->fetchAll();
    $total_parent = $parents['0']['total'];
    

    $query = "SELECT COUNT(*) AS total FROM classes ";
    $post = $db->prepare($query);
    $post->execute();
    $classes = $post->fetchAll();
    $total_classe = $classes['0']['total'];
    

    $query = "SELECT COUNT(*) AS total FROM users ";
    $post = $db->prepare($query);
    $post->execute();
    $users = $post->fetchAll();
    $total_user = $users['0']['total'];
    
  
} catch (PDOException $e) {
  $e->getMessage();
  exit();
}


require_once "header.php";
?>

    <nav class="navbar navbar-dark bg-dark fixed-top" style="margin-left: 18%;"> 
      <div class="container-fluid">
        <div class="mx-auto text-white navbar-text">
          <h3>Dashboard</h3>
        </div>
      </div>
    </nav>

    <main class="main-content" style="margin-left: 20%">
  <div class=" pb-8 pt-5">
  <div class="container-fluid mt-5">
      <div class="row g-4">
        <div class="col-md-6">
          <div class="card card-stats" style=" width: 300px; height: 100px">
            <div class="card-body">
              <div class="row ">
                <div class="col">
                  <h5 class="card-title ">Étudiants</h5>
                  <span class="h2 font-weight-bold mb-0"><?= $total_etudiant ?></span>
                </div>
                <div class="col-auto">
                  <div class="icon icon-shape bg-info text-white rounded-circle shadow">
                    <i class="fas fa-graduation-cap fs-2"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      <?php if($auth_role == "directeur") : ?>
        <div class=" col-md-6">
          <div class="card card-stats" style=" width: 300px; height: 100px">
            <div class="card-body">
              <div class="row ">
                <div class="col">
                  <h5 class="card-title ">Secrétaires</h5>
                  <span class="h2 font-weight-bold mb-0"><?= $total_user ?></span>
                </div>
                <div class="col-auto">
                  <div class="icon icon-shape bg-warning text-white rounded-circle shadow">
                    <i class="fas fa-user-edit fs-2"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      <?php endif; ?>
      </div>
      <div class="row g-4">
        <div class="col-md-6">
          <div class="card card-stats" style=" width: 300px; height: 100px;">
            <div class="card-body">
              <div class="row ">
                <div class="col">
                  <h5 class="card-title ">Parents</h5>
                  <span class="h2 font-weight-bold mb-0"><?= $total_parent ?></span>
                </div>
                <div class="col-auto">
                  <div class="icon icon-shape bg-warning text-white rounded-circle shadow">
                    <i class="fas fa-users fs-2"></i> 
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class=" col-md-6">
          <div class="card card-stats" style=" width: 300px; height: 100px;">
            <div class="card-body">
              <div class="row">
                <div class="col">
                  <h5 class="card-title ">Classes</h5>
                  <span class="h2 font-weight-bold mb-0"><?= $total_classe ?></span>
                </div>
                <div class="col-auto">
                  <div class="icon icon-shape bg-danger text-white rounded-circle shadow">
                    <i class="fas fa-school  fs-2"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
</main>