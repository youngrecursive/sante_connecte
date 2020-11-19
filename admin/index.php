<?php
session_start();
require('../inc/function.php');
require('../inc/pdo.php');

if(!isLoggedAdmin()) {
  header('Location: ../index.php');
  exit(); }

  $formbyyear = false;
  if(!empty($_GET['id'])) {
    $formbyyear = true;
    $xplode = explode('/',$_GET['id']);
    $annee = $xplode[0];
    $xplodate = explode('-',$annee);

    $id = $xplode[1];





  }

    $sql = "SELECT * FROM vaccins ORDER BY ID desc";
    $query = $pdo->prepare($sql);
    $query->execute();
    $data = $query->fetchAll();
    //debug($data);

    if(!empty($_POST['submitted'])){

        header('Location: index.php?id='.$_POST['year'].'/'.$_POST['vaccin'].'');
        exit();
    }



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

              <?php
                // NBR TOTAL D'USER
                $sql = "SELECT COUNT(id) FROM nf_users";
                      $query = $pdo->prepare($sql);
                      $query->execute();
                      $nbrusers = $query->fetchColumn();


                      // NBR TOTAL USERS VACCINES
                      $sql = "SELECT COUNT(DISTINCT user_id) FROM vaccins_user";
                      $query = $pdo->prepare($sql);
                      $query->execute();
                      $nbruservaccs = $query->fetchColumn();

                      $prctg_user_vaccs = $nbruservaccs / $nbrusers * 100;

                  ?>

                  <div class="stats_index">


                    <span class="badge badge-pill badge-success info-stat"><?= round($prctg_user_vaccs,1); ?> % des utilisateurs ont renseigné au moins un vaccin</span>
                    <span class="badge badge-pill badge-danger info-stat"><?= 100 - round($prctg_user_vaccs,1); ?> % des utilisateurs n'ont pas renseigné de vaccin</span>
                  </div>



                    <div class="graphique">


                      <h1 class="nbrvacs">Nombre de vaccins en <?= date('Y'); ?></h1>
                      <form class="" action="" method="post">
                        <input type="date" name="year" value="">
                        <select class="" name="vaccin">
                          <option value="vaccin">Vaccins</option>
                          <?php foreach ($data as $dat): ?>
                            <option value="<?= $dat['id'] ?>"><?= $dat['nomvaccin']; ?></option>
                          <?php endforeach; ?>
                          <input type="submit" name="submitted" value="Envoyer">
                        </select>
                      </form>
                      <div class="container_graph">


                      <?php
                      $mois = [1,2,3,4,5,6,7,8,9,10,11,12];


                      foreach ($mois as $moi) {
                         ?>

                        <div class="graph">

                          <?php
                          //$month = $datevaccin['MONTH(date_vaccin)']; ?>
                          <div class="petit-container-month">


                            <p><?= monthIntegerToString($moi); ?></p>
                          </div>
                          <?php
                          if(empty($formbyyear)) {
                            $sql = "SELECT COUNT(id) FROM vaccins_user WHERE MONTH(date_vaccin) = '$moi' AND YEAR(date_vaccin) = YEAR(NOW()) ORDER BY MONTH(date_vaccin) ASC";
                            $query = $pdo->prepare($sql);
                            $query->execute();
                            $userpermonth = $query->fetchcolumn();
                          }
                          else {
                            $sql = "SELECT COUNT(id) FROM vaccins_user WHERE vaccin_id = '$id' AND MONTH(date_vaccin) = '$moi' AND YEAR(date_vaccin) = YEAR('$annee/02/02') ORDER BY MONTH(date_vaccin) ASC";
                            $query = $pdo->prepare($sql);
                            $query->execute();
                            $userpermonth = $query->fetchcolumn();
                            debug($userpermonth);
                          }


                          ?>


                          <div class="petit-container-content">


                            <p class="badge badge-pill badge-primary"><?= $userpermonth; ?> Vaccins</p>

                            <p class="graph_courbe" style=" padding:<?= $userpermonth*20; ?>px 0px;">

                          </p>

                          </div>

                        </div>


                      <?php } ?>

                    </div>

                  </div>


              <!-- END OF STATS -->

              <!-- HTML CONTENT -->



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
                                              <th class="text-primary">Péremption (en mois)</th>
                                          </tr>
                                      </thead>
                                      <tbody>
                                        <?php
                                        // $errors = array();

                                        $sql = "SELECT * FROM vaccins ORDER BY id desc LIMIT 5";
                                        $query = $pdo->prepare($sql);
                                        $query->execute();
                                        $vaccins = $query->fetchAll();
                                        foreach ($vaccins as $vaccin) { ?>
                                          <tr>
                                            <td><?php echo($vaccin['nomvaccin']); ?></td>
                                            <td><?php echo($vaccin['nombrerappel']); ?></td>
                                            <td><?php echo($vaccin['intervallerappel']); ?></td>
                                            <td><?php echo($vaccin['peremption']); ?></td>
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
                                            <th class="text-primary" >Nom </th>
                                            <th class="text-primary">Prénom</th>
                                            <th class="text-primary">Civilitée</th>
                                            <th class="text-primary">Ville</th>
                                            <th class="text-primary">Date de création</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                      <?php
                                      // $errors = array();

                                      $sql = "SELECT * FROM nf_users ORDER BY created_at desc LIMIT 5";
                                      $query = $pdo->prepare($sql);
                                      $query->execute();
                                      $users = $query->fetchAll();
                                      foreach ($users as $user) { ?>
                                        <tr>
                                          <td><?php echo($user['nom']); ?></td>
                                          <td><?php echo($user['prenom']); ?></td>
                                          <td><?php echo($user['civilitee']); ?></td>
                                          <td><?php echo($user['ville']); ?></td>
                                          <td><?php echo($user['created_at']); ?></td>
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
