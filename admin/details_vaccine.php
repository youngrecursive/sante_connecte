  <?php
  session_start();
  require('../inc/function.php');
  require('../inc/pdo.php');

  if(!isLoggedAdmin()) {
    header('Location: 403.php');
    exit(); }


  //on récupère l'ID dans l'url
    $errors=array();
    if(!empty($_GET['id']) && is_numeric($_GET['id'])){
      $id = $_GET['id'];
      //fetch le vaccin dans la BDD

    $sql = "SELECT * FROM vaccins WHERE id = :id";
    $query = $pdo->prepare($sql);
    $query->bindValue(':id',$id,PDO::PARAM_INT);
    $query->execute();
    $vaccins = $query->fetch();

    $sql = "SELECT * FROM nf_users INNER JOIN vaccins_user ON nf_users.id = vaccins_user.user_id WHERE vaccin_id = '$id'";
    $query = $pdo->prepare($sql);
    $query->execute();
    $users = $query->fetchAll();
    // debug($users);
    if(!empty($users)){
      $userVaccin = array();
      $userkey = '';
      foreach ($users as $key => $user) {
        if($user['id'] == $id) {
          $userVaccin = $user;
          $userkey = $key;
        }
      }
    }
  } else {
    header('Location: 404.php');
    exit();
  }

  $sql = "SELECT * FROM vaccins WHERE id = :id";
  $query = $pdo->prepare($sql);
  $query->bindValue(':id',$id,PDO::PARAM_INT);
  $query->execute();
  $vaccins = $query->fetch();

include('inc/header.php'); ?>
<!-- on utilise les données qu'on a fetch et on les affiches -->
  <div class="container-fluid">
    <h1 class="text-dark">Détails</h1>
    <p class="text-dark"><span class="text-info">Nom du vaccin:</span> <?= $vaccins['nomvaccin'];?></p>
    <p class="text-dark"><span class="text-info">Description :</span> <?= $vaccins['description'];?></p>
    <p class="text-warning"><?= $vaccins['nombrerappel'];?> rappels à effectuer.</p>
    <p class="text-warning">Un rappel tous les <?= $vaccins['intervallerappel'];?> mois à effectuer</p>
    <p class="text-warning">Périmé au bout de  <?= $vaccins['intervallerappel'];?> mois.</p>
    <!-- boutton back stylisé via boostrap -->
    <div class="my-2"></div>
    <a href="new_vaccine.php" class="btn btn-light btn-icon-split">
      <span class="icon text-gray-600">
        <i class="fas fa-arrow-right"></i>
      </span>
      <span class="text">Retourner sur la table des vaccins</span>
    </a>
    </div>

    <!-- permet de créer un espace via un boostrap utilities -->
  <div class="my-3"></div>

<div class="container-fluid">
    <div class="card shadow mb-4">
      <div class="d-block card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Liste des vaccins :</h6>
      </div>
    <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th class="text-primary">Nom de l'utilisateur</th>
                <th class="text-primary">ID de l'utilisateur</th>
                <th class="text-primary">Date de mise à jour</th>
                <th class="text-primary">Date de vaccination</th>
              </tr>
            </thead>
            <?php $user_id = $_GET['id'];
            foreach ($users as $user): ?>
                <tr>
                  <td class="text-dark"> <?= $user['nom'] ?></td>
                  <td class="text-dark"> <?= $user['user_id'] ?></td>
                  <td class="text-dark"> <?= $user['updated_at'] ?></td>
                  <td class="text-dark">  <?= formatageShortDate($user['date_vaccin']) ?></td>
                </tr>
                <?php endforeach;
                 ?>
              </table>
        </div>
    </div>
    </div>
</div>


<?php include('inc/footer.php'); ?>
