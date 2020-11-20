<?php
session_start();
require('../inc/function.php');
require('../inc/pdo.php');

if(!isLoggedAdmin()) {
  header('Location: 403.php');
  exit(); }

//valiation du formulaire
$errors = array();
if (!empty($_POST['submitted'])) {
  // faille xss
  $nomvaccin   = cleanXss($_POST['nomvaccin']);
  $description = cleanXss($_POST['description']);
  $nombrerappel = cleanXss($_POST['nombrerappel']);
  $intervallerappel = cleanXss($_POST['intervallerappel']);
  $intervallerappel = cleanXss($_POST['peremption']);

  //validation nomvaccin  (min 2,max 50)
  $errors = validText($errors,$nomvaccin,'nomvaccin',2,50);
  //validation description (min 2 , max 500)
  $errors = validText($errors,$description,'description',2,500);
  $errors = validNumber($errors,$nombrerappel,'nombrerappel',0,50);
  $errors = validNumber($errors,$intervallerappel,'intervallerappel',0,100);
  $errors = validNumber($errors,$intervallerappel,'peremption',0,100);

  //insertion dans la base de donnée, s'il n'y a pas d'erreur dans le formulaire
  if (count($errors) == 0) {
    $nombrerappel = $_POST['nombrerappel'];
    $intervallerappel = $_POST ['intervallerappel'];
    $peremption = $_POST ['peremption'];
    $sql = "INSERT INTO vaccins (nomvaccin,description,nombrerappel,intervallerappel,peremption)
            VALUES (:nomvaccin,:description, $nombrerappel,$intervallerappel,$peremption)";
    $query = $pdo->prepare($sql);
    $query->bindValue(':nomvaccin',$nomvaccin,PDO::PARAM_STR);
    $query->bindValue(':description',$description,PDO::PARAM_STR);
    $query->execute();

    header('Location: tables2.php');
    exit();

      // die('You Died');
  }
}

include('inc/header.php'); ?>

  <div class="container-fluid">
    <!-- Titre de page -->
    <h1 class="text-dark">Nouveau Vaccin</h1>

    <!-- début section vaccin -->

    <!-- début formulaire nouveau vaccin -->
      <form class="form-check"  method="POST">

<!-- Ajout d'un vaccin, et affichage des erreurs d'entrées. -->
        <div class="control-form">
          <label class="form-check-label text-dark" for="vaccin">Nom du vaccin</label>
          <input class="form-control w-50" type="text" name="nomvaccin" id="nomvaccin" value="<?php if(!empty($_POST['nomvaccin'])) { echo $_POST['nomvaccin']; } ?>">
          <span class="error_form text-danger"><?php if(!empty($errors['nomvaccin'])) { echo $errors['nomvaccin']; } ?></span>
        </div>
<!-- ajout d'une description, et affichage des erreurs d'entrées -->
          <div class="control-form">
            <label class="form-check-label text-dark" for="description">Description</label>
            <textarea class="form-control form-text w-50" name="description" id="description" rows="8" cols="80" style=resize:none;><?php if(!empty($_POST['description'])) { echo $_POST['description']; } ?></textarea>
            <span class="error_form text-danger"><?php if(!empty($errors['description'])) { echo $errors['description']; } ?></span>
          </div>
<!-- ajout des rappels, et affichagedes erreurs d'entrées -->
          <div class="control-form">
            <label  class="form-check-label text-dark" for="nombrerappel">Nombre de rappel</label>
            <input class="form-control w-50" type="number" name="nombrerappel" id="nombrerappel" placeholder="Exemple: 5">
            <span class="error_form text-danger"><?php if(!empty($errors['nombrerappel'])) { echo $errors['nombrerappel']; } ?></span>
          </div>
<!-- ajout de l'intervalle de rappel  et affichag des erreurs d'entrées-->
          <div class="control-form">
            <label class="form-check-label text-dark" for="intervallerappel">Intervalle de rappel (en mois)</label>
            <input class="form-control w-50" type="number" name="intervallerappel" placeholder="Exemple: 10">
            <span class="error_form text-danger"><?php if(!empty($errors['intervallerappel'])) { echo $errors['intervallerappel']; } ?></span>
          </div>
<!-- ajout de la date de péremption du vaccin et affichage des erreurs d'entrées -->
          <div class="control-form">
            <label class="form-check-label text-dark" for="intervallerappel">Péremption (en Années)</label>
            <input class="form-control w-50" type="number" name="peremption" placeholder="Exemple: 8">
            <span class="error_form text-danger"><?php if(!empty($errors['peremption'])) { echo $errors['premption']; } ?></span>
          </div>
          <!-- bouton submit stylisé avec le bootstrap -->
          <div class="my-2"></div>
          <div class="btn btn-success btn-icon-split">
          <span class="icon text-white-50">
              <i class="fas fa-check"></i>
          </span>
          <input class="btn btn-success btn-icon-split" type="submit" name="submitted" value="  Ajouter un vaccin  ">
          </div>
      </form>

      <div class="my-2"></div>
      <a href="tables2.php" class="btn btn-light btn-icon-split">
        <span class="icon text-gray-600">
          <i class="fas fa-arrow-right"></i>
        </span>
        <span class="text">Retourner sur la table des vaccins</span>
      </a>
  <!-- permet de laisser un espace, via une commande bootstrap -->
  <div class="my-3"></div>


  </div>

<?php include('inc/footer.php'); ?>
