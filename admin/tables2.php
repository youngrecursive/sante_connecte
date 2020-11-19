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

    <!-- TABLE DES VACCINS -->
    <div class="card shadow mb-4">
      <a href="#collapseCardExample" class="d-block card-header py-3" data-toggle="collapse"
          role="button" aria-expanded="true" aria-controls="collapseCardExample">
            <h6 class="m-0 font-weight-bold text-primary">Liste des vaccins :</h6>
      </a>
        <div class="collapse show" id="collapseCardExample">
          <div class="card-body">
              <div class="table-responsive">
                  <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                      <thead>
                          <tr>
                              <th class="text-primary">Nom du vaccin</th>
                              <th class="text-primary">Description</th>
                              <th class="text-primary">Nombre de rappel</th>
                              <th class="text-primary">Intervalle de rappel (en mois)</th>
                              <th class="text-primary">Péremption (en mois)</th>
                              <th class="text-primary">Détails</th>
                              <th class="text-primary">Modifier</th>
                              <th class="text-primary">Supprimer</th>
                          </tr>
                      </thead>
                      <tbody>
                        <?php
                        // $errors = array();

                        $sql = "SELECT * FROM vaccins";
                        $query = $pdo->prepare($sql);
                        $query->execute();
                        $data = $query->fetchAll();
                        for ($i=0; $i < count($data) ; $i++) { ?>
                          <tr>
                            <td class="text-dark"><?php echo($data[$i]['nomvaccin']); ?></td>
                            <td class="text-dark"><?php echo($data[$i]['description']); ?></td>
                            <td class="text-dark"><?php echo($data[$i]['nombrerappel']); ?></td>
                            <td class="text-dark"><?php echo($data[$i]['intervallerappel']); ?></td>
                            <td class="text-dark"><?php echo($data[$i]['peremption']); ?></td>


                            <!-- bouton détails stylisé via le bootsrap -->
                            <td><a href="details_vaccine.php?id=<?php echo($data[$i]['id']); ?>" class="btn btn-info btn-icon-split">
                              <span class="icon text-white-50">
                                  <i class="fas fa-info-circle"></i>
                              </span>
                              <span class="text"><?php echo 'Details' ?></span>
                              </a></td>

                            <!-- bouton modifier stylysé via le bootstrap -->
                            <td><a href="edit_vaccine.php?id=<?php echo($data[$i]['id']); ?>" class="btn btn-secondary btn-icon-split">
                              <span class="icon text-white-50">
                                  <i class="fas fa-info-circle"></i>
                              </span>
                              <span class="text"><?php echo 'Modifier' ?></span>
                              </a></td>

                            <!-- bouton delete stylysé via le bootstrap -->
                            <td><a href="delete_vaccine.php?id=<?php echo($data[$i]['id']); ?>" class="btn btn-danger btn-icon-split">
                              <span class="icon text-white-50">
                                  <i class="fas fa-trash"></i>
                              </span>
                              <span class="text"><?php echo 'Supprimer' ?></span>
                          </a></td>

                          </tr>
                          <?php
                        }
                        ?>
                      </table>
                  </tbody>
              </div>
            </div>
        </div>
      </div>
<!-- /.container-fluid -->
  <div class="my-2"></div>
  <a href="new_vaccine.php" class="btn btn-light btn-icon-split">
    <span class="icon text-gray-600">
      <i class="fas fa-arrow-right"></i>
    </span>
    <span class="text">Créer un nouveau vaccin</span>
  </a>

</div>

<?php include('inc/footer.php'); ?>
