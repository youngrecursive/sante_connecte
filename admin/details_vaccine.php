  <?php
  session_start();
  require('../inc/function.php');
  require('../inc/pdo.php');

  if(!isLoggedAdmin()) {
    header('Location: ../index.php');
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

  include('inc/header.php'); ?>
  <!-- on utilise les données qu'on a fetch et on les affiches -->
    <div class="container-fluid">
      <h1>Détails</h1>
      <p>Nom du vaccin: <?= $vaccins['nomvaccin'];?></p>
      <p>Description : <?= $vaccins['description'];?></p>
      <p><?= $vaccins['nombrerappel'];?> rappels à effectuer.</p>
      <p>Un rappel tous les <?= $vaccins['intervallerappel'];?> mois à effectuer</p>
      <a href="new_vaccine.php">Retourner sur la table des vaccins</a>
    </div>


  <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
    <thead>
      <tr>
        <th>Nom de l'utilisateur</th>
        <th>ID de l'utilisateur:</th>
        <th>Date de mise à jour:</th>
        <th>Date de vaccination:</th>
      </tr>
    </thead>
    <?php $user_id = $_GET['id'];
    foreach ($users as $user): ?>
        <tr>
          <td> <?= $user['nom'] ?></td>
          <td> <?= $user['user_id'] ?></td>
          <td> <?= $user['updated_at'] ?></td>
          <td> <?= formatageShortDate($user['date_vaccin']) ?></td>
        </tr>
        <?php endforeach;
         ?>
      </table>

<?php include('inc/footer.php'); ?>
