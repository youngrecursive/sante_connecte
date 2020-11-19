<?php
session_start();
require('../inc/function.php');
require('../inc/pdo.php');

if(!isLoggedAdmin()) {
  header('Location: 403.php');
  exit(); }

include('inc/header.php'); ?>
  <div class="container-fluid">
    <h1></h1>
  </div>
  <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

          <!-- Begin Page Content -->
          <div class="container-fluid">

              <!-- Page Heading -->
              <div class="d-sm-flex align-items-center justify-content-between mb-4">
                  <h1 class="h3 mb-0 text-gray-800">Index</h1>
              </div>

              <div class="row">
                <div class="col-xl-6  col-lg-4">
                    <div class="card shadow mb-4 border-left-info">
                        <!-- Card Header - Dropdown -->
                        <div
                            class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary">5 derniers vaccins ajoutés</h6>
                            <div class="dropdown no-arrow">
                                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                    aria-labelledby="dropdownMenuLink">
                                    <div class="dropdown-header">Plus d'actions</div>
                                    <a class="dropdown-item" href="tables2.php">Voir tous les vaccins</a>
                                    <a class="dropdown-item" href="new_vaccine.php">Ajouter un vaccin</a>
                                </div>
                            </div>
                          </div>
                          <div class="card-body">
                              <div class="table-responsive">
                                  <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                          </td>
                                        </tr>
                                      <thead>
                                          <tr>
                                              <th class="text-primary">Nom du vaccin</th>
                                              <th class="text-primary">Nombre de rappel</th>
                                              <th class="text-primary">Intervalle de rappel (en mois)</th>
                                              <th class="text-primary">Péremption (en année)</th>
                                          </tr>
                                      </thead>
                                      <tbody>
                                        <?php
                                        // $errors = array();

                                        $sql = "SELECT * FROM vaccins ORDER BY ID desc";
                                        $query = $pdo->prepare($sql);
                                        $query->execute();
                                        $data = $query->fetchAll();
                                        for ($i=0; $i < 5 ; $i++) { ?>
                                          <tr>
                                            <td><?php echo($data[$i]['nomvaccin']); ?></td>
                                            <td><?php echo($data[$i]['nombrerappel']); ?></td>
                                            <td><?php echo($data[$i]['intervallerappel']); ?></td>
                                            <td><?php echo($data[$i]['peremption']); ?></td>
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

              <div class="col-xl-6 col-lg-4 ">
                  <div class="card shadow mb-4 border-left-info">
                      <!-- Card Header - Dropdown -->
                      <div
                          class="card-header py-3 d-flex flex-row align-items-center justify-content-between ">
                          <h6 class="m-0 font-weight-bold text-primary">5 derniers utilisateurs inscrits</h6>
                          <div class="dropdown no-arrow">
                              <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                  <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                              </a>
                              <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                  aria-labelledby="dropdownMenuLink">
                                  <div class="dropdown-header">Plus d'actions</div>
                                  <a class="dropdown-item" href="tables.php">Voir tous les utilisateurs</a>
                                  <a class="dropdown-item" href="#">Modifier / Supprimer un nouvel utilisateur</a>
                              </div>
                          </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        </td>
                                      </tr>
                                    <thead>
                                        <tr>
                                            <th class="text-primary">Nom </th>
                                            <th class="text-primary">Prénom</th>
                                            <th class="text-primary">Civilitée</th>
                                            <th class="text-primary">Ville</th>
                                            <th class="text-primary">Date de création</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                      <?php
                                      // $errors = array();

                                      $sql = "SELECT * FROM nf_users ORDER BY created_at desc";
                                      $query = $pdo->prepare($sql);
                                      $query->execute();
                                      $data = $query->fetchAll();
                                      for ($i=0; $i <= 5; $i++) { ?>
                                        <tr>
                                          <td><?php echo($data[$i]['nom']); ?></td>
                                          <td><?php echo($data[$i]['prenom']); ?></td>
                                          <td><?php echo($data[$i]['civilitee']); ?></td>
                                          <td><?php echo($data[$i]['ville']); ?></td>
                                          <td><?php echo($data[$i]['created_at']); ?></td>
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
          </div>
          <?php  $sql = "SELECT COUNT(id) FROM nf_users";
                  $query = $pdo->prepare($sql);
                  $query->execute();
                  $data = $query->fetchColumn();
                  // debug($data);
            ?>
            <?php $sql = "SELECT COUNT(DISTINCT user_id) FROM vaccins_user";
                  $query = $pdo->prepare($sql);
                  $query->execute();
                  $data = $query->fetchColumn();
                  // echo $data;
              ?>
              <?php
                $sql = "SELECT date_vaccin FROM vaccins_user";
                $query = $pdo->prepare($sql);
                $query->execute();
                $datevaccins = $query->fetchAll();
                // debug($datevaccins);
                ?>

          <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

<?php include('inc/footer.php'); ?>
