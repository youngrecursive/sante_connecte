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
                          <th class="text-primary">ID</th>
                          <th class="text-primary">Nom</th>
                          <th class="text-primary">Prenom</th>
                          <th class="text-primary">Civilité</th>
                          <th class="text-primary">Date de naissance</th>
                          <th class="text-primary">Adresse Principale</th>
                          <th class="text-primary">Adresse Secondaire</th>
                          <th class="text-primary">Ville</th>
                          <th class="text-primary">CP</th>
                          <th class="text-primary">E-mail</th>
                          <th class="text-primary">Crée le</th>
                          <th class="text-primary">Mis à jour le</th>
                          <th class="text-primary">Détails</th>
                          <th class="text-primary">Modifier</th>
                          <th class="text-primary">Supprimer</th>
                      </tr>
                    </thead>
                    <tfoot>
                          <tr>
                              <th class="text-primary">ID</th>
                              <th class="text-primary">Nom</th>
                              <th class="text-primary">Prenom</th>
                              <th class="text-primary">Civilité</th>
                              <th class="text-primary">Date de naissance</th>
                              <th class="text-primary">Adresse Principale</th>
                              <th class="text-primary">Adresse Secondaire</th>
                              <th class="text-primary">Ville</th>
                              <th class="text-primary">CP</th>
                              <th class="text-primary">E-mail</th>
                              <th class="text-primary">Crée le</th>
                              <th class="text-primary">Mis à jour le</th>
                              <th class="text-primary">Détails</th>
                              <th class="text-primary">Modifier</th>
                              <th class="text-primary">Supprimer</th>
                          </tr>
                    </tfoot>
                    <tbody>

                      <?php
                      $sql = "SELECT * FROM nf_users";
                      $query = $pdo->prepare($sql);
                      $query->execute();
                      $users = $query->fetchAll();

                      foreach ($users as $user) { ?>
                        <tr>
                          <td><?= $user['id']; ?></td>
                          <td><?= $user['nom']; ?></td>
                          <td><?= $user['prenom']; ?></td>
                          <td><?= $user['civilitee']; ?></td>
                          <td><?= $user['date_naissance']; ?></td>
                          <td><?= $user['adresse1']; ?></td>
                          <td><?= $user['adresse2']; ?></td>
                          <td><?= $user['ville']; ?></td>
                          <td><?= $user['codepostal']; ?></td>
                          <td><?= $user['email']; ?></td>
                          <td><?= $user['created_at']; ?></td>
                          <td><?= $user['updated_at']; ?></td>
                          <!-- bouton détails stylisé via le bootsrap -->
                          <td><a href="details.php?id=<?php echo($user['id']); ?>" class="btn btn-info btn-icon-split">
                            <span class="icon text-white-50">
                                <i class="fas fa-info-circle"></i>
                            </span>
                            <span class="text"><?php echo 'Voir' ?></span>
                            </a></td>
                          <!-- bouton modifier stylysé via le bootstrap -->
                          <td><a href="edit.php?id=<?php echo($user['id']); ?>" class="btn btn-secondary btn-icon-split">
                            <span class="icon text-white-50">
                                <i class="fas fa-info-circle"></i>
                            </span>
                            <span class="text"><?php echo 'Modifier' ?></span>
                            </a></td>
                          <!-- bouton delete stylysé via le bootstrap -->
                          <td><a href="delete.php?id=<?php echo($user['id']); ?>" class="btn btn-danger btn-icon-split">
                          <span class="icon text-white-50">
                              <i class="fas fa-trash"></i>
                          </span>
                          <span class="text"><?php echo 'Supprimer' ?></span>
                          </a></td>
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
