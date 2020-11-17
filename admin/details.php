<?php session_start(); ?>
<?php require('../inc/function.php'); ?>
<?php require('../inc/pdo.php'); ?>


<?php if(!isLoggedAdmin()) {
  header('Location: ../index.php');
  exit(); }

  $sql = "SELECT * FROM nf_users";
  $query = $pdo->prepare($sql);
  $query->execute();
  $users = $query->fetchAll();
  if(!empty($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id']; // recuperation dans url
    $userDetails = array();
    $userkey = '';
    foreach ($users as $key => $user) {
      if($user['id'] == $id) {
        $userDetails = $user;
        $userkey = $key;
      }
    }
    if(empty($userDetails)) {
      die('404');
    }
  } else {
    die('404');
  }

include('inc/header.php'); ?>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Détails de l'utilisateur:</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    </td>
                  </tr>
                <thead>
                  <tr>
                    <th>Nom</th>
                    <th>Prenom</th>
                    <th>Civilite</th>
                    <th>Date de naissance</th>
                    <th>Crée le:</th>
                    <th>Mis à jour le:</th>
                </tr>
            </thead>
                  <td> <?= $userDetails['nom']; ?></td>
                  <td> <?= $userDetails['prenom']; ?></td>
                  <td> <?= $userDetails['civilitee']; ?></td>
                  <td> <?= $userDetails['date_naissance']; ?></td>
                  <td> <?= $userDetails['created_at']; ?></td>
                  <td> <?= $userDetails['updated_at']; ?></td>
                </table>


<?php include('inc/footer.php');
