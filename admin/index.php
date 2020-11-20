<?php
session_start();
require('../inc/function.php');
require('../inc/pdo.php');

if(!isLoggedAdmin()) {
  header('Location: ../index.php');
  exit(); }

/// STATS USER QUI ONT FAIT AU MOINS UN VACCIN ////

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

/// VALUE TO POURCENTAGE
$prctg_user_vaccs = $nbruservaccs / $nbrusers * 100;



///// PETIT DIAGRAMME /////
//// Vérifs manquantes par manque de temps, notamment les vérifs URl, peut-être d'autres ?

$affichage = 0;
$formbyyear = false;
if(!empty($_GET['id'])) {

  $formbyyear = true;
  $xplode = explode('/',$_GET['id']);
  if (is_numeric($xplode[0])) {
    $annee = $xplode[0];
    if(!empty($xplode[1])) {
      if(is_numeric($xplode[1])) {
        // SI ON RECUPERE ANNEE ET VACCIN
        $id = $xplode[1];
        $affichage = 2;
        $sql = "SELECT nomvaccin FROM vaccins WHERE id = '$id'";
        $query = $pdo->prepare($sql);
        $query->execute();
        $current_vaccin = $query->fetch();

        $sql = "SELECT count(id) FROM vaccins_user WHERE YEAR(date_vaccin) = YEAR('$annee/02/02') AND vaccin_id = '$id'";
        $query = $pdo->prepare($sql);
        $query->execute();
        $count_total_each = $query->fetchcolumn();
        debug($count_total_each);
      }
    }
    // SI ON RECUPERE ANNEE MAIS PAS LE VACCIN
    else {
      $affichage = 1;
      $sql = "SELECT count(id) FROM vaccins_user WHERE YEAR(date_vaccin) = YEAR('$annee/02/02')";
      $query = $pdo->prepare($sql);
      $query->execute();
      $count_total = $query->fetchcolumn();
    }
  }

  // NOT GET : DEFAUT : Tous les vaccins année courante
  }
  else {
    $sql = "SELECT count(id) FROM vaccins_user WHERE YEAR(date_vaccin) = YEAR(NOW())";
    $query = $pdo->prepare($sql);
    $query->execute();
    $count_total_current = $query->fetchcolumn();
  }


  // LA REQUETE ICI NOUS SERT POUR AFFICHER LES VACCINS DANS LE SELECT DU FORMULAIRE DU PETIT DIAGRAMME
  $sql = "SELECT * FROM vaccins ORDER BY ID desc";
  $query = $pdo->prepare($sql);
  $query->execute();
  $data = $query->fetchAll();

  // VERIFS AVANT D'ENVOYER DANS L'URL des choses qui n'existeraient pas...
  $errors = array();
  if(!empty($_POST['submitted'])){
    $year = $_POST['year'];
    $errors = validYear($errors,$year,'year');

    if(count($errors) == 0) {
      if(!empty($_POST['vaccin'])) {
        header('Location: index.php?id='.$_POST['year'].'/'.$_POST['vaccin'].'');
        exit();
      }
      else {
        header('Location: index.php?id='.$_POST['year'].'/');
        exit();
      }
    }


  }
  //// FIN DU PHP DIAGRAMME ////



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
                  <!-- STATS HTML -->
                  <div class="stats_index">
                    <span class="badge badge-pill badge-success info-stat"><?= round($prctg_user_vaccs,1); ?> % des utilisateurs ont renseigné au moins un vaccin</span>
                    <span class="badge badge-pill badge-danger info-stat"><?= 100 - round($prctg_user_vaccs,1); ?> % des utilisateurs n'ont pas renseigné de vaccin</span>
                  </div>


                    <!--  DIAGRAMME HTML + PHP -->

                    <!-- PAS DE RESPONSIVE, CSS A FAIRE -->

                    <!-- Problème d'affichage coloration syntaxique sur atom mais fonctionne -->
                    <div class="graphique">


                      <h1 class="nbrvacs">Nombre de vaccins <?php if($affichage == 2) { echo 'du '.$current_vaccin['nomvaccin'].' '; } ?> effectués en <?php if(!empty($annee)) { echo $annee; } else { echo date('Y');} if($affichage == 1) { echo ' ('.$count_total.')'; } elseif($affichage == 2) { echo ' ('.$count_total_each.')'; } elseif($affichage == 0) { echo ' ('.$count_total_current.')'; }
                       ?>
                      </h1>
                      <!-- FORM DIAGRAMME -->
                      <form class="diagramme-form" action="" method="post">
                        <input class="inpt-year" placeholder="2020" type="text" maxlength = "4" name="year" value="<?php if(!empty($formbyyear) && $affichage == (1 || 2) ) { echo $annee; } if($affichage == 0) { echo date('Y');} ?>">
                        <span><?php if(!empty($errors['year'])){ echo $errors['year']; } ?></span>
                        <select class="inpt-vacc" name="vaccin">
                          <option value="">All</option>
                          <?php foreach ($data as $dat): ?>
                            <option value="<?= $dat['id'] ?>"><?= $dat['nomvaccin']; ?></option>
                          <?php endforeach; ?>
                          <input class="btn btn-dark btn-icon-split inpt-submit" type="submit" name="submitted" value="Afficher">
                        </select>
                      </form>
                      <div class="container_graph">


                      <?php
                      // ICI ON FAIT UN FOREACH DES MOIS POUR AFFICHER MEME LES MOIS OU IL N Y A PAS DE VACCINS FAITS.
                      // Count peut renvoyer 0 donc pas de problème à ne niveau là.
                      $mois = [1,2,3,4,5,6,7,8,9,10,11,12];
                      foreach ($mois as $moi) {
                         ?>

                        <div class="graph">
                          <div class="petit-container-month">
                            <p><?= monthIntegerToString($moi); ?></p>
                          </div>
                          <?php
                          //// CI DESSOUS LES REQUETES SONT DIFFERENTES SELON L'URL,

                          if(empty($formbyyear)) {
                            $sql = "SELECT COUNT(id) FROM vaccins_user WHERE MONTH(date_vaccin) = '$moi' AND YEAR(date_vaccin) = YEAR(NOW()) ORDER BY MONTH(date_vaccin) ASC";
                            $query = $pdo->prepare($sql);
                            $query->execute();
                            $userpermonth = $query->fetchcolumn();
                          }
                          else {
                            if($affichage == 1){
                              $sql = "SELECT COUNT(id) FROM vaccins_user WHERE MONTH(date_vaccin) = '$moi' AND YEAR(date_vaccin) = YEAR('$annee/02/02') ORDER BY MONTH(date_vaccin) ASC";
                              $query = $pdo->prepare($sql);
                              $query->execute();
                              $userpermonth = $query->fetchcolumn();
                            }
                            elseif($affichage == 2){
                              $sql = "SELECT COUNT(id) FROM vaccins_user WHERE vaccin_id = '$id' AND MONTH(date_vaccin) = '$moi' AND YEAR(date_vaccin) = YEAR('$annee/02/02') ORDER BY MONTH(date_vaccin) ASC";
                              $query = $pdo->prepare($sql);
                              $query->execute();
                              $userpermonth = $query->fetchcolumn();
                            }
                          }

                          ?>
                          <!-- Padding relatif d'où le css dans le html ( :D ) -->
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

              <!-- 5 DERNIERS VACCINS AJOUTES -->
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

              <!-- 5 DERNIERS USERS INSCRITS -->

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


<?php include('inc/footer.php'); ?>
