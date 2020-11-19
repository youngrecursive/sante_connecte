<?php
session_start();
require('../inc/function.php');
require('../inc/pdo.php');

if(!isLoggedAdmin()) {
  header('Location: ../index.php');
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
                            <h6 class="m-0 font-weight-bold text-primary">5 derniers vaccins ajoutéss</h6>
                            <div class="dropdown no-arrow">
                                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                    aria-labelledby="dropdownMenuLink">
                                    <div class="dropdown-header">Plus d'actions</div>
                                    <a class="dropdown-item" href="tables2.php">Voir tous les vaccins</a>
                                    <a class="dropdown-item" href="new_vaccine.php">Ajouter / Modifier / Supprimer un vaccin</a>
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
                                              <th>Nom du vaccin</th>
                                              <th>Nombre de rappel</th>
                                              <th>Intervalle de rappel (en mois)</th>
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
                                            <th>Nom </th>
                                            <th>Prénom</th>
                                            <th>Civilitée</th>
                                            <th>Ville</th>
                                            <th>Date de création</th>
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

          <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->
      <!-- Bootstrap core JavaScript-->
      <script src="startbootstrap-sb-admin-2-gh-pages/vendor/jquery/jquery.min.js"></script>
      <script src="startbootstrap-sb-admin-2-gh-pages/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

      <!-- Core plugin JavaScript-->
      <script src="startbootstrap-sb-admin-2-gh-pages/vendor/jquery-easing/jquery.easing.min.js"></script>

      <!-- Custom scripts for all pages-->
      <script src="startbootstrap-sb-admin-2-gh-pages/js/sb-admin-2.min.js"></script>

      <!-- Page level plugins -->
      <script src="startbootstrap-sb-admin-2-gh-pages/vendor/chart.js/Chart.min.js"></script>

      <!-- Page level custom scripts -->
      <script src="startbootstrap-sb-admin-2-gh-pages/js/demo/chart-area-demo.js"></script>
      <script src="startbootstrap-sb-admin-2-gh-pages/js/demo/chart-pie-demo.js"></script>

<?php include('inc/footer.php'); ?>
