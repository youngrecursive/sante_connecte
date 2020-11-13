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
                      foreach ($data as $value) {
                      echo'<tr><td>'.$value['id'].'</td><td>'.$value['nom'].'</td><td>'.$value['prenom'].'</td><td>'.$value['civilitee'].'</td><td>'.$value['date_naissance'].'</td><td>'.$value['adresse1'].'</td><td>'.$value['adresse2'].'</td><td>'.$value['ville'].'</td><td>'.$value['codepostal'].'</td><td>'.$value['role'].'</td><td>'.$value['email'].'</td><td>'.$value['password'].'</td><td>'.$value['created_at'].'</td></tr>';}

                      if(isset($GET['supprime']) AND !empty($_GET['supprime'])) {
                        $supprime = (int) $_GET['supprime'];
                        $sql = "DELETE FROM nf_users WHERE id = ?";
                        $sql = $do->prepare($sql);
                        $query->execute();
                        }
                        ?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- TABLE USERS VACCINES -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Table des utilisateurs vaccinés:</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>ID de l'utilisateur</th>
                            <th>ID du vaccin</th>
                            <th>Date de vaccination</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                          <th>ID</th>
                          <th>ID de l'utilisateur</th>
                          <th>ID du vaccin</th>
                          <th>Date de vaccination</th>
                        </tr>
                    </tfoot>
                    <tbody>
                      <?php
                      $sql = "SELECT * FROM vaccins_user";
                      $query = $pdo->prepare($sql);
                      $query->execute();
                      $data = $query->fetchAll();
                      foreach ($data as $value) {
                      echo'<tr><td>'.$value['id'].'</td><td>'.$value['user_id'].'</td><td>'.$value['vaccin_id'].'</td><td>'.$value['date_vaccin'].'</td></tr>';}
                      ?> }
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- TABLE UTILISATEURS -->
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
                      $data = $query->fetchAll();
                      foreach ($data as $value) {
                      echo'<tr><td>'.$value['id'].'</td><td>'.$value['nomvaccin'].'</td><td>'.$value['description'].'</td><td>'.$value['nombrerappel'].'</td><td>'.$value['intervallerappel'].'</td></tr>';}
                      ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

<!-- /.container-fluid -->

</div>

<?php include('inc/footer.php'); ?>
