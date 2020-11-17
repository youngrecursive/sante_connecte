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
                            <th>Détails</th>
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
                            <th>Mis à jour le:</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                          <th>Détails</th>
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
                          <th>Mis à jour le:</th>
                        </tr>
                    </tfoot>
                    <tbody>
                      <?php
                      // $errors = array();

                      $sql = "SELECT * FROM nf_users";
                      $query = $pdo->prepare($sql);
                      $query->execute();
                      $users = $query->fetchAll();

                      foreach ($users as $user) { ?>
                        <tr>
                          <td><a href=details.php?id=<?php echo $user['id']; ?> >Voir</a></td>
                          <td><?= $user['id']; ?></td>
                          <td><?= $user['nom']; ?></td>
                          <td><?= $user['prenom']; ?></td>
                          <td><?= $user['civilitee']; ?></td>
                          <td><?= $user['date_naissance']; ?></td>
                          <td><?= $user['adresse1']; ?></td>
                          <td><?= $user['adresse2']; ?></td>
                          <td><?= $user['ville']; ?></td>
                          <td><?= $user['codepostal']; ?></td>
                          <td><?= $user['role']; ?></td>
                          <td><?= $user['email']; ?></td>
                          <td><?= $user['password']; ?></td>
                          <td><?= $user['created_at']; ?></td>
                          <td><?= $user['updated_at']; ?></td>
                          <td><a href=edit.php?id=<?php echo $user['id']; ?> >Modifier</a></td>
                          <td><a href=delete.php?id=<?php echo $user['id']; ?> >Supprimer</a></td>
                        </tr>
                        <?php
                      }
                      ?>
                    </table>
                    <td><a href=newuser.php?id=<?php echo $user['id']; ?> >Ajouter un utilisateur</a></td>
                </tbody>
            </div>
        </div>
    </div>

<!-- /.container-fluid -->

</div>

<?php include('inc/footer.php'); ?>
