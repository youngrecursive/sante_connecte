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

    <!-- TABLE DES VACCINS -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Table des vaccins:</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nom du vaccin</th>
                            <th>Description</th>
                            <th>Nombre de rappel</th>
                            <th>Intervalle de rappel</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                          <th>ID</th>
                          <th>Nom du vaccin</th>
                          <th>Description</th>
                          <th>Nombre de rappel</th>
                          <th>Intervalle de rappel</th>
                        </tr>
                    </tfoot>
                    <tbody>
                      <?php
                      $sql = "SELECT * FROM vaccins";
                      $query = $pdo->prepare($sql);
                      $query->execute();
                      $vaccins = $query->fetchAll();
                      foreach ($vaccins as $vaccin) { ?>
                        <tr>
                          <td><?= $vaccin['id']; ?></td>
                          <td><?= $vaccin['nomvaccin']; ?></td>
                          <td><?= $vaccin['description']; ?></td>
                          <td><?= $vaccin['nombrerappel']; ?></td>
                          <td><?= $vaccin['intervallerappel']; ?></td>
                        </tr>
                        <?php
                      }
                      ?>
                      </table>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

<!-- /.container-fluid -->

</div>

<?php include('inc/footer.php'); ?>
