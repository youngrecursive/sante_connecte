<?php
session_start();
require('../inc/function.php');
require('../inc/pdo.php');

if(!isLoggedAdmin()) {
  header('Location: 403.php');
  exit(); }


  //on récupère les infos du vaccins déjà existante
  $errors=array();
  if(!empty($_GET['id']) && is_numeric($_GET['id'])){
    $id = $_GET['id'];
    //sfetch le vaccin dans la BDD
  $sql = "SELECT * FROM vaccins WHERE id = :id";
  $query = $pdo->prepare($sql);
  $query->bindValue(':id',$id,PDO::PARAM_INT);
  $query->execute();
  $vaccins = $query->fetch();
  if(!empty($vaccins)){//le vaccin existe dans la BDD
    if(!empty($_POST['submitted'])){//Le formulaire est soumis
      //on se protège des failles xss
      $success=true;
      $nomvaccin   = cleanXss($_POST['nomvaccin']);
      $description = cleanXss($_POST['description']);
      $nombrerappel = cleanXss($_POST['nombrerappel']);
      $intervallerappel = cleanXss($_POST['intervallerappel']);
      $peremption = cleanXss($_POST['peremption']);
      //on valide avec les mêmes condition qu'avant
      //validation nomvaccin  (min 2,max 50)
      $errors = validText($errors,$nomvaccin,'nomvaccin',2,50);
      //validation description (min 2 , max 500)
      $errors = validText($errors,$description,'description',2,500);
      $errors = validNumber($errors,$nombrerappel,'nombrerappel',0,50);
      $errors = validNumber($errors,$intervallerappel,'intervallerappel',0,100);
      $errors = validNumber($errors,$peremption,'peremption',0,100);
      //si tout est bon on update
      if (count($errors) == 0) {
        $nombrerappel = $_POST['nombrerappel'];
        $intervallerappel = $_POST ['intervallerappel'];
        $sql = "UPDATE vaccins
                SET nomvaccin = :nomvaccin, description = :description,nombrerappel=$nombrerappel,intervallerappel=$intervallerappel,peremption=$peremption
                WHERE id = :id";
        $query = $pdo->prepare($sql);
        $query->bindValue(':nomvaccin',$nomvaccin,PDO::PARAM_STR);
        $query->bindValue(':description',$description,PDO::PARAM_STR);
        $query->bindValue(':id',$id,PDO::PARAM_INT);
        $query->execute();

        header('Location: tables2.php');
      }
    }
  }else{ //il n'existe pas, 404.
    header('Location: 404.php');
  }
} else {
  header('Location: 404.php');
}

include('inc/header.php'); ?>
  <div class="container-fluid">
    <h1 class="text-dark">Modifier son vaccin</h1>
      <!-- formulaire pour la modification du fichier -->
      <form class="form-check" method="POST">

        <!-- modification d'un nom de vaccin -->
        <div class="control-form">
          <label class="form-check-label text-dark" for="vaccin">Nom du vaccin</label>
          <input class="form-control w-50" type="text" name="nomvaccin" id="nomvaccin" value="<?php if(!empty($_POST['nomvaccin'])) { echo $_POST['nomvaccin'];} else {echo $vaccins['nomvaccin'];} ?>">
          <span class="error_form text-danger"><?php if(!empty($errors['nomvaccin'])) { echo $errors['nomvaccin']; } ?></span>
        </div>
  <!-- modification d'une description, et affichage des erreurs d'entrées -->
        <div class="control-form">
          <label class="form-check-label text-dark" for="description">Description</label>
          <textarea class="form-control form-text w-50" name="description" id="description" rows="8" cols="80" ><?php if(!empty($_POST['description'])) { echo $_POST['description'];} else {echo $vaccins['description'];} ?></textarea>

          <span class="error_form text-danger"><?php if(!empty($errors['description'])) { echo $errors['description']; } ?></span>
        </div>

  <!-- modification des rappels, et affichagedes erreurs d'entrées -->
        <div class="control-form">
          <label class="form-check-label text-dark" for="nombrerappel">Nombre de rappel</label>

          <input class="form-control w-50" type="number" name="nombrerappel" id="nombrerappel" value="<?php if(!empty($_POST['nombrerappel'])) { echo $_POST['nombrerappel'];} else {echo $vaccins['nombrerappel'];}?>" >

          <span class="error_form text-danger"><?php if(!empty($errors['nombrerappel'])) { echo $errors['nombrerappel']; } ?></span>
        </div>


  <!-- modification de l'intervalle de rappel  et affichag des erreurs d'entrées-->
        <div class="control-form">
          <label class="form-check-label text-dark" for="intervallerappel">Intervalle de rappel (mois)</label>

          <input class="form-control w-50" type="number" name="intervallerappel" value="<?php if(!empty($_POST['intervallerappel'])) { echo $_POST['intervallerappel'];} else {echo $vaccins['intervallerappel'];}?>">

          <span class="error_form text-danger"><?php if(!empty($errors['intervallerappel'])) { echo $errors['intervallerappel']; } ?></span>
        </div>

<!-- date de péremption -->
        <div class="control-form">
          <label class="form-check-label text-dark" for="intervallerappel">Péremption (en années)</label>
          <input class="form-control w-50" type="number" name="peremption" value="<?php if(!empty($_POST['peremption'])) { echo $_POST['peremption'];} else {echo $vaccins['peremption'];}?>">
          <span class="error_form text-danger"><?php if(!empty($errors['peremption'])) { echo $errors['premption']; } ?></span>
        </div>

        <div class="my-2"></div>
        <div class="btn btn-success btn-icon-split">
        <span class="icon text-white-50">
            <i class="fas fa-check"></i>
        </span>
        <input class="btn btn-success btn-icon-split" type="submit" name="submitted" value="  Modifier un vaccin  ">
        </div>

      </form>
      <div class="my-2"></div>
      <a href="new_vaccine.php" class="btn btn-light btn-icon-split">
        <span class="icon text-gray-600">
          <i class="fas fa-arrow-right"></i>
        </span>
        <span class="text">Retourner sur la table des vaccins</span>
      </a>
      <div class="control-form">

    </div>


  </div>


<?php include('inc/footer.php'); ?>
