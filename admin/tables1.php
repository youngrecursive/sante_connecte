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
    <!-- <p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below.
        For more information about DataTables, please visit the <a target="_blank"
            href="https://datatables.net">official DataTables documentation</a>.</p> -->

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
                            <th>ID</th>
                            <th>ID de l'utilisateur</th>
                            <th>ID du vaccin</th>
                            <th>Date de vaccination</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                          <th>ID</th>
                          <th>ID de l'utilisateur</th>
                          <th>ID du vaccin</th>
                          <th>Date de vaccination</th>
                        </tr>
                    </tfoot>
                    <tbody>
                      <?php
                      $sql = "SELECT * FROM vaccins_user";
                      $query = $pdo->prepare($sql);
                      $query->execute();
                      $data = $query->fetchAll();
                      for ($i=0; $i < count($data) ; $i++) { ?>
                        <tr>
                          <td><?php echo($data[$i]['id']); ?></td>
                          <td><?php echo($data[$i]['user_id']); ?></td>
                          <td><?php echo($data[$i]['vaccin_id']); ?></td>
                          <td><?php echo($data[$i]['date_vaccin']); ?></td>
                          <td><a href=edit.php?m=<?php echo ($data[$i]['id']); ?> >Modifier</a></td>
                          <td><a href=delete.php?m=<?php echo ($data[$i]['id']); ?> >Supprimer</a></td>
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
