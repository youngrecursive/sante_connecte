<?php
session_start();
require('inc/pdo.php');
require('inc/function.php');
$errors = array();
// On vérifie maintenant que user est connecté, plus besoin de vérifier ensuite si $_SESSION existe

if(isLoggedUser() || isLoggedAdmin()) {

  if(!empty($_GET['id'])) {


    // ON RECUPERE 2 VALEURS DANS L'ULR AVEC CETTE TECHNIQUE PHP JAPONAISE
    $xplode = explode('/', $_GET['id']);
    $user_id = $xplode[0];
    $vaccin_id = $xplode[1];
    $id = $_SESSION['user']['id'];

    // On vérifie que id concorde avec l'user connecté
    if($_SESSION['user']['id'] !== $user_id) { header('Location: 404.php'); exit(); }

    if(is_numeric($user_id) && is_numeric($vaccin_id)) {

      if(!empty($_POST['submitted'])){
        $date_vaccin = cleanXss($_POST['date_vaccin']);
        $errors = validDate($errors,$date_vaccin,'date_vaccin');

        if(count($errors) == 0){
          $sql = "UPDATE vaccins_user SET date_vaccin = :date_vaccin WHERE user_id = :user_id AND vaccin_id = :vaccin_id";
          $query = $pdo->prepare($sql);
          $query->bindValue(':date_vaccin', $date_vaccin,PDO::PARAM_STR);
          $query->bindValue(':user_id', $user_id,PDO::PARAM_INT);
          $query->bindValue(':vaccin_id', $vaccin_id,PDO::PARAM_INT);
          $query->execute();

          header('Location: user_see_vacs.php?id='.$id.'/update');
          exit();

        }

      }

    }

    // ID PAS NUMERIQUE DONC FAUX
    else {
      header('Location: 404.php');
      exit();

    }


  }
  else {
    header('Location: 404.php');
    exit();
  }

}

// PAS CONNECTE
else {
  header('Location: 404.php');
  exit();
}
?>



<?php
include('inc/header.php');
?>


<form class="" action="" method="post">
  <div class="date">
    <label id="" for="date_vaccin">Date du vaccin : </label>
    <input type="date" name="date_vaccin" max="9999-12-31" value="<?php if(!empty($_POST['date_vaccin'])) { echo $_POST['date_vaccin']; } ?>">
    <span class="error"><?php if(!empty($errors['date_vaccin'])) { echo $errors['date_vaccin']; } ?></span>
  </div>
  <input class="submit" type="submit" name="submitted" value="Envoyer">
</form>




<?php
include('inc/footer.php');
 ?>
