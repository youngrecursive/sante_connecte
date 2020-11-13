<?php session_start(); ?>
<?php require('../inc/function.php'); ?>
<?php require('../inc/pdo.php'); ?>

<?php if(!isLoggedAdmin()) {
  header('Location: ../index.php');
  exit(); } ?>

<!-- valiation du formulaire -->
<?php
$errors = array();
if (!empty($_POST['submitted'])) {
  // faille xss
  $nomvaccin   = cleanXss($_POST['nomvaccin']);
  $description = cleanXss($_POST['description']);

  //validation nomvaccin  (2,50)
  $errors = validText($errors,$nomvaccin,'nomvaccin',2,50);
  $errors = validText($errors,$description,'description',2,500);

  if (count($errors) == 0) {
    $success = true;
    $nombrerappel = $_POST['nombrerappel'];
    $sql = "INSERT INTO vaccins (nomvaccin,description,nombrerappel)
            VALUES (:nomvaccin,:description, $nombrerappel)";
    $query = $pdo->prepare($sql);
    $query->bindValue(':nomvaccin',$nomvaccin,PDO::PARAM_STR);
    $query->bindValue(':description',$description,PDO::PARAM_STR);
    $query->execute();

      // die('You Died');

  }

}

?>

<?php include('inc/header.php'); ?>

  <div class="container-fluid">
    <!-- Titre de page -->
    <h1 class="h3 mb-2 text-gray-800">Ajouter un nouveau vaccin</h1>
    <!-- début formulaire nouveau vaccin -->
        <form class=""  method="POST">
          <div class="form_group">
          <label for="vaccin">Nom du vaccin</label>
            <input type="text" name="nomvaccin" id="nomvaccin" value="<?php if(!empty($_POST['nomvaccin'])) { echo $_POST['nomvaccin']; } ?>">

            <span class="error_form"><?php if(!empty($errors['nomvaccin'])) { echo $errors['nomvaccin']; } ?></span>
          </div>

          <div class="form_group">
            <label for="description">Description</label>
            <textarea name="description" id="description" rows="8" cols="80" value"<?php if(!empty($_POST['description'])) { echo $_POST['description']; } ?>"></textarea>

            <span class="error_form"><?php if(!empty($errors['description'])) { echo $errors['description']; } ?></span>
          </div>

          <div class="form_group">
            <label for="nombrerappel">Nombre de rappel</label>
            <input type="number" name="nombrerappel" id="nombrerappel" value="0" min ="0" max="999" >
            <span class="error_form"></span>
          </div>

          <!-- <div class="form_group">
            <label for="intervallerappel">Nombre de rappel</label>
            <input type="number" name="" value="" min ="0" max="999">
          </div> -->

          <input type="submit" name="submitted" value="Ajouter un vaccin">
        </form>

  </div>

<?php include('inc/footer.php'); ?>
