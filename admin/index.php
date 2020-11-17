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

              <!-- Content Row -->
              <div class="row">

                  <!-- Earnings (Monthly) Card Example -->
                  <div class="col-xl-3 col-md-6 mb-4">
                      <div class="card border-left-primary shadow h-100 py-2">
                          <div class="card-body">
                              <div class="row no-gutters align-items-center">
                                  <div class="col mr-2">
                                      <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                          Earnings (Monthly)</div>
                                      <div class="h5 mb-0 font-weight-bold text-gray-800">$40,000</div>
                                  </div>
                                  <div class="col-auto">
                                      <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>

                  <!-- Earnings (Monthly) Card Example -->
                  <div class="col-xl-3 col-md-6 mb-4">
                      <div class="card border-left-success shadow h-100 py-2">
                          <div class="card-body">
                              <div class="row no-gutters align-items-center">
                                  <div class="col mr-2">
                                      <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                          Earnings (Annual)</div>
                                      <div class="h5 mb-0 font-weight-bold text-gray-800">$215,000</div>
                                  </div>
                                  <div class="col-auto">
                                      <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>

                  <!-- Earnings (Monthly) Card Example -->
                  <div class="col-xl-3 col-md-6 mb-4">
                      <div class="card border-left-info shadow h-100 py-2">
                          <div class="card-body">
                              <div class="row no-gutters align-items-center">
                                  <div class="col mr-2">
                                      <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Tasks
                                      </div>
                                      <div class="row no-gutters align-items-center">
                                          <div class="col-auto">
                                              <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">50%</div>
                                          </div>
                                          <div class="col">
                                              <div class="progress progress-sm mr-2">
                                                  <div class="progress-bar bg-info" role="progressbar"
                                                      style="width: 50%" aria-valuenow="50" aria-valuemin="0"
                                                      aria-valuemax="100"></div>
                                              </div>
                                          </div>
                                      </div>
                                  </div>
                                  <div class="col-auto">
                                      <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>

                  <!-- Pending Requests Card Example -->
                  <div class="col-xl-3 col-md-6 mb-4">
                      <div class="card border-left-warning shadow h-100 py-2">
                          <div class="card-body">
                              <div class="row no-gutters align-items-center">
                                  <div class="col mr-2">
                                      <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                          Pending Requests</div>
                                      <div class="h5 mb-0 font-weight-bold text-gray-800">18</div>
                                  </div>
                                  <div class="col-auto">
                                      <i class="fas fa-comments fa-2x text-gray-300"></i>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>

              <div class="row">
                <div class="col-xl-6  col-lg-4">
                    <div class="card shadow mb-4">
                        <!-- Card Header - Dropdown -->
                        <div
                            class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary">5 derniers utilisateurs inscrits</h6>
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

              <div class="col-xl-6 col-lg-4">
                  <div class="card shadow mb-4">
                      <!-- Card Header - Dropdown -->
                      <div
                          class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                          <h6 class="m-0 font-weight-bold text-primary">5 derniers utilisateurs inscrits</h6>
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
                                      for ($i=0; $i <= 1; $i++) { ?>
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


<?php include('inc/footer.php'); ?>
