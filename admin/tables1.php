<?php session_start(); ?>
<?php require('../inc/function.php'); ?>
<?php require('../inc/pdo.php'); ?>

<?php if(!isLoggedAdmin()) {
  header('Location: ../index.php');
  exit(); } ?>

<?php include('inc/header.php'); ?>
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Base de données</h1>

    <!-- TABLE USERS VACCINES -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Table des utilisateurs vaccinés:</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                          <th class="text-primary">ID</th>
                          <th class="text-primary">ID de l'utilisateur</th>
                          <th class="text-primary">ID du vaccin</th>
                          <th class="text-primary">Date de vaccination</th>
                        </tr>
                    </thead>
                    <tfoot>
                      <tr>
                          <th class="text-primary">ID</th>
                          <th class="text-primary">ID de l'utilisateur</th>
                          <th class="text-primary">ID du vaccin</th>
                          <th class="text-primary">Date de vaccination</th>
                      </tr>
                    </tfoot>
                    <tbody>
                      <?php
                      $sql = "SELECT * FROM vaccins_user";
                      $query = $pdo->prepare($sql);
                      $query->execute();
                      $users = $query->fetchAll();
                      foreach ($users as $user) { ?>
                        <tr>
                          <td><?= $user['id']; ?></td>
                          <td><?= $user['user_id']; ?></td>
                          <td><?= $user['vaccin_id']; ?></td>
                          <td><?= $user['date_vaccin']; ?></td>
                        </tr>
                        <?php
                      }
                      ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

<!-- /.container-fluid -->

</div>

<?php include('inc/footer.php'); ?>
