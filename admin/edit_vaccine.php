<?php
session_start();
require('../inc/function.php');
require('../inc/pdo.php');

if(!isLoggedAdmin()) {
  header('Location: ../index.php');
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
      $nomvaccin   = cleanXss($_POST['nomvaccin']);
      $description = cleanXss($_POST['description']);
      //on valide avec les mêmes condition qu'avant
      //validation nomvaccin  (min 2,max 50)
      $errors = validText($errors,$nomvaccin,'nomvaccin',2,50);
      //validation description (min 2 , max 500)
      $errors = validText($errors,$description,'description',2,500);
      //si tout est bon on update
      if (count($errors) == 0) {
        $nombrerappel = $_POST['nombrerappel'];
        $intervallerappel = $_POST ['intervallerappel'];
        $sql = "UPDATE vaccins
                SET nomvaccin = :nomvaccin, description = :description,nombrerappel=$nombrerappel,intervallerappel=$intervallerappel
                WHERE id = :id";
        $query = $pdo->prepare($sql);
        $query->bindValue(':nomvaccin',$nomvaccin,PDO::PARAM_STR);
        $query->bindValue(':description',$description,PDO::PARAM_STR);
        $query->bindValue(':id',$id,PDO::PARAM_INT);
        $query->execute();

        header('Location: new_vaccine.php');
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
    <h1>Modifier son vaccin</h1>
      <!-- formulaire pour la modification du fichier -->
      <form class="" method="POST">
        <label for="vaccin">Nom du vaccin</label>
          <input type="text" name="nomvaccin" id="nomvaccin" value="<?php if(!empty($_POST['nomvaccin'])) { echo $_POST['nomvaccin']; } ?>">
          <span class="error_form"><?php if(!empty($errors['nomvaccin'])) { echo $errors['nomvaccin']; } ?></span>

  <!-- modification d'une description, et affichage des erreurs d'entrées -->
        <div class="form_group">
          <label for="description">Description</label>
          <textarea name="description" id="description" rows="8" cols="80" value"<?php if(!empty($_POST['description'])) { echo $_POST['description']; } ?>"></textarea>
          <span class="error_form"><?php if(!empty($errors['description'])) { echo $errors['description']; } ?></span>
        </div>

  <!-- modification des rappels, et affichagedes erreurs d'entrées -->
        <div class="form_group">
          <label for="nombrerappel">Nombre de rappel</label>
          <input type="number" name="nombrerappel" id="nombrerappel" value="0" min ="0" >
          <span class="error_form"></span>
        </div>

  <!-- modification de l'intervalle de rappel  et affichag des erreurs d'entrées-->
        <div class="form_group">
          <label for="intervallerappel">Intervalle de rappel (mois)</label>
          <input type="number" name="intervallerappel" value="0" min ="0  ">
          <span class="error_form"></span>
        </div>

        <input type="submit" name="submitted" value="Modifier un vaccin">
      </form>
    <a href="new_vaccine.php">Retourner sur la table des vaccins</a>
  </div>


<?php include('inc/footer.php'); ?>
