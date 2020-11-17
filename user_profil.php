<?php
// VISIBLE SEULEMENT POUR USERS CONNECTES ET VALIDES
session_start();
include('inc/pdo.php');
include('inc/function.php');
 ?>

<?php
 if(isLoggedUser() || isLoggedAdmin()) {
  if(!empty($_GET['id'] && is_numeric($_GET['id'])))
  {
    if($_SESSION['user']['id'] == $_GET['id']) { $id = $_GET['id']; }
    else { header('Location: 404.php'); exit(); }
    $pseudo = $_SESSION['user']['pseudo'];

    $sql = "SELECT * FROM nf_users WHERE id = '$id' AND email = '$pseudo'";
    $query = $pdo->prepare($sql);
    $query->execute();
    $user = $query->fetch();

    if(!empty($user)){
      ////
      //debug($user);
      ////
      $errors = array();

      if(!empty($_POST['submitted'])) {

        $adresse1 = cleanXss($_POST['adresse1']);
        $adresse2 = cleanXss($_POST['adresse2']);
        $ville = cleanXss($_POST['ville']);
        $codepostal = cleanXss($_POST['codepostal']);

        $errors = validTextNull($errors,$adresse1,'adresse1',2,75);
        $errors = validTextNull($errors,$adresse2,'adresse2',2,75);
        $errors = validTextNull($errors,$ville,'ville',2,40);
        $errors = validPostalNull($errors,$codepostal,'codepostal');


        if(count($errors) == 0){

          $sql = "UPDATE nf_users SET adresse1 = :adresse1, adresse2 = :adresse2, ville = :ville, codepostal = :codepostal WHERE id = '$id' AND email = '$pseudo'";
          $query = $pdo->prepare($sql);
          $query->bindValue(':adresse1',$adresse1,PDO::PARAM_STR);
          $query->bindValue(':adresse2',$adresse2,PDO::PARAM_STR);
          $query->bindValue(':ville',$ville,PDO::PARAM_STR);
          $query->bindValue(':codepostal',$codepostal,PDO::PARAM_STR);
          $query->execute();


          // On refresh à chaque envoie pour avoir les données à jour
          header('Location: user_profil.php?id='.$_SESSION['user']['id'].'');
          exit();

        }

      }
    }
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
else {
  header('Location: 404.php');
  exit();
}
 ?>


<?php
include('inc/header.php'); ?>



<form class="" action="" method="post">

  <!-- Adresse1 -->
  <label for="adresse1">Adresse 1</label>
  <input type="text" name="adresse1" value="<?php if(!empty($user['adresse1'])) { echo $user['adresse1']; } ?>">
  <span class="error"><?php if(!empty($errors['adresse1'])) { echo $errors['adresse1']; } ?></span>
  <!-- Adresse2 -->
  <label for="adresse2">Adresse 2</label>
  <input type="text" name="adresse2" value="<?php if(!empty($user['adresse2'])) { echo $user['adresse2']; } ?>">
  <span class="error"><?php if(!empty($errors['adresse2'])) { echo $errors['adresse2']; } ?></span>
  <!-- Ville -->
  <label for="ville">ville</label>
  <input type="text" name="ville" value="<?php if(!empty($user['ville'])) { echo $user['ville']; } ?>">
  <span class="error"><?php if(!empty($errors['ville'])) { echo $errors['ville']; } ?></span>
  <!-- Code postal -->
  <label for="codepostal">Code postal</label>
  <input type="text" name="codepostal" maxlength="5" value="<?php if(!empty($user['codepostal'])) { echo $user['codepostal']; } ?>">
  <span class="error"><?php if(!empty($errors['codepostal'])) { echo $errors['codepostal']; } ?></span>

  <!-- Submit -->
  <input type="submit" name="submitted" value="Envoyer">

</form>


<?php
include('inc/footer.php');
