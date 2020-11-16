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

    <!-- TABLE UTILISATEURS -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Table des utilisateurs:</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        </td>
                      </tr>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nom</th>
                            <th>Prenom</th>
                            <th>Civilite</th>
                            <th>Date de naissance</th>
                            <th>Adresse Principale</th>
                            <th>Adresse Secondaire</th>
                            <th>Ville</th>
                            <th>CP</th>
                            <th>Role</th>
                            <th>E-mail</th>
                            <th>Password</th>
                            <th>Crée le:</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                          <th>ID</th>
                          <th>Nom</th>
                          <th>Prenom</th>
                          <th>Civilite</th>
                          <th>Date de naissance</th>
                          <th>Adresse Principale</th>
                          <th>Adresse Secondaire</th>
                          <th>Ville</th>
                          <th>CP</th>
                          <th>Role</th>
                          <th>E-mail</th>
                          <th>Password</th>
                          <th>Crée le:</th>
                        </tr>
                    </tfoot>
                    <tbody>
                      <?php
                      $errors = array();

                      $sql = "SELECT * FROM nf_users";
                      $query = $pdo->prepare($sql);
                      $query->execute();
                      $data = $query->fetchAll();
                      for ($i=0; $i < count($data) ; $i++) { ?>
                        <tr>
                          <td><?php echo($data[$i]['id']); ?></td>
                          <td><?php echo($data[$i]['nom']); ?></td>
                          <td><?php echo($data[$i]['prenom']); ?></td>
                          <td><?php echo($data[$i]['civilitee']); ?></td>
                          <td><?php echo($data[$i]['date_naissance']); ?></td>
                          <td><?php echo($data[$i]['adresse1']); ?></td>
                          <td><?php echo($data[$i]['adresse2']); ?></td>
                          <td><?php echo($data[$i]['ville']); ?></td>
                          <td><?php echo($data[$i]['codepostal']); ?></td>
                          <td><?php echo($data[$i]['role']); ?></td>
                          <td><?php echo($data[$i]['email']); ?></td>
                          <td><?php echo($data[$i]['password']); ?></td>
                          <td><?php echo($data[$i]['created_at']); ?></td>
                          <td><?php echo($data[$i]['updated_at']); ?></td>
                          <td><a href=edit.php?m=<?php echo ($data[$i]['id']); ?> >Modifier</a></td>
                          <td><a href=delete.php?m=<?php echo ($data[$i]['id']); ?> >Supprimer</a></td>
                        </tr>
                        <?php
                      }
                      ?>
                    </table>
                </tbody>
            </div>
        </div>
    </div>

<!-- /.container-fluid -->

</div>

<?php include('inc/footer.php'); ?>
