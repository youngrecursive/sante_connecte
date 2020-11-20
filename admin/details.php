<?php session_start(); ?>
<?php require('../inc/function.php'); ?>
<?php require('../inc/pdo.php'); ?>


<?php if(!isLoggedAdmin()) {
  header('Location: 403.php');
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

      $sql = "SELECT * FROM vaccins INNER JOIN vaccins_user ON vaccins.id = vaccins_user.vaccin_id WHERE user_id = '$id'";
      $query = $pdo->prepare($sql);
      $query->execute();
      $madevaccins = $query->fetchAll();
      if(!empty($madevaccins)){
        $successvac = true;
      }

      /////// STATS ////////

      ///// NOMBRE TOTAL DE VACCIN
      $sql = "SELECT COUNT(id) FROM vaccins";
      $query = $pdo->prepare($sql);
      $query->execute();
      $nbrvaccins = $query->fetchcolumn();


      ///// NOMBRE DE VACCIN FAIT POUR TEL USER?
      $id = $_GET ['id'];
      $sql = "SELECT COUNT(vaccins.id) FROM vaccins INNER JOIN vaccins_user ON vaccins.id = vaccins_user.vaccin_id WHERE user_id = '$id'";
      $query = $pdo->prepare($sql);
      $query->execute();
      $vaccinusers = $query->fetchcolumn();

      //// POURCENTAGE DE VACCINS FAIT PAR TEL USER

      $prctg = $vaccinusers / $nbrvaccins * 100;
      $prctgleft = 100 - $prctg;



    include('inc/header.php'); ?>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary"><span class="badge badge-success">Pourcentage de vaccins effectués : <?= round($prctg,1).'%'; ?></span></h6>
        <br><h6 class="m-0 font-weight-bold text-primary"><span class="badge badge-danger">Pourcentage de vaccins non effectués : <?= round($prctgleft,1).'%'; ?></span></h6></br>
        <h6 class="m-0 font-weight-bold text-primary"><br>Détails de l'utilisateur:</br></h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                  <tr>
                    <th class="text-primary">Nom</th>
                    <th class="text-primary">Prenom</th>
                    <th class="text-primary">Civilite</th>
                    <th class="text-primary">Date de naissance</th>
                    <th class="text-primary">Mis à jour le:</th>
                </tr>
            </thead>
                  <td> <?= $userDetails['nom']; ?></td>
                  <td> <?= $userDetails['prenom']; ?></td>
                  <td> <?= $userDetails['civilitee']; ?></td>
                  <td> <?= $userDetails['date_naissance']; ?></td>
                  <td> <?= $userDetails['updated_at']; ?></td>
            </table>

            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th class="text-primary">Vaccin(s):</th>
                  <th class="text-primary">Fait(s) le:</th>
                </tr>
              </thead>
                  <?php if(!empty($successvac)){ ?>
                    <?php $user_id = $_GET['id'];
                      foreach ($madevaccins as $madevaccin): ?>
                <tr>
                  <td> <?= $madevaccin['nomvaccin'] ?></td>
                  <td> <?= formatageShortDate($madevaccin['date_vaccin']) ?></td>
                  <td><a href="user_delete_vac.foruser.php?id=<?= $user_id ?>/<?= $madevaccin['nomvaccin'] ?>">Retirer ce vaccin</a></td>
                </tr>
                <?php endforeach;
              } ?>
                </table>
            <a href="tables.php">&larr; Retour à la liste des utilisateurs</a>


      <?php include('inc/footer.php');
