<?php

require('inc/pdo.php');
require('inc/function.php');
$success = false;
$errors = array();

if (empty($_GET['id']) && is_numeric($_GET['id'])) {
  die('404');
}

// ON VERIFIE QUE URL CORRESPOND A UNE PERSONNE QUI EXISTE
else {
  $token = $_GET['id'];
  $sql = "SELECT * FROM nf_users WHERE token = '$token'";
  $query = $pdo->prepare($sql);
  $query->execute();
  $user = $query->fetch();

  // ON VERIFIE QUE USER EXISTE AVEC LE MEME ID QUE CELUI DE URL
  if(!empty($user)) {

    // SI LE FORMULAIRE EST SOUMIS
    if(!empty($_POST['submitted'])){
      $email    = cleanXss($_POST['email']);
      $password = cleanXss($_POST['password']);
      $password2 = cleanXss($_POST['password2']);
      $errors = validPass($errors,$password,'password',$password2,2,100);

      // ON VA CHERCHER USER EN QUESTIONS QUI A UN EMAIL DEJA EXISTANT
      $sql = "SELECT * FROM nf_users WHERE email = :email AND token = '$token'";
      $query = $pdo->prepare($sql);
      $query->bindValue(':email',$email,PDO::PARAM_STR);
      $query->execute();
      $user = $query->fetch();

      // SI USER EMAIL EXISTE ALORS ON PEUT CHANGER SON MOT DE PASSE
      if(!empty($user)){
        // SI MOT DE PASSE EST OK
        if (count($errors) == 0){
          $token2 = generateRandomString(120);
          $password = password_hash($password, PASSWORD_DEFAULT);
          $sql = "UPDATE nf_users SET password = :password, token = NULL, token2 = '$token2', role = 'user' WHERE token = '$token'";
          $query = $pdo->prepare($sql);
          //$query->bindValue(':email',$email,PDO::PARAM_STR);
          $query->bindValue(':password',$password,PDO::PARAM_STR);
          $query->execute();

          header('Location: login.php');
          exit();
        }


      }
      else {
        $errors ['email'] = 'Email incorrect';
      }

    }


  }
  else{
    die('404');
  }
}


include('inc/header.php'); ?>

<form class="formulaire" action="" method="post">
  <!-- EMAIL -->
  <label id="email" for="email">Email</label>
  <input type="text" name="email" placeholder="Email" value="<?php if(!empty($_POST['email'])) { echo $_POST['email']; } ?>">
  <span><?php if(!empty($errors['email'])) { echo $errors['email']; } ?></span>

  <!-- PASSWORD -->
  <label for="password"></label>
  <input type="password" name="password" placeholder="3 caractères min"value="<?php if(!empty($_POST['password'])) { echo $_POST['password']; } ?>">
  <span><?php if(!empty($errors['password'])) { echo $errors['password']; } ?></span>

  <!-- CONFIRM PASSWORD -->
  <label for="password2"></label>
  <input type="password" name="password2" placeholder="Confirmation Mot de passe" value="<?php if(!empty($_POST['password2'])) { echo $_POST['password2']; } ?>">
  <span><?php if(!empty($errors['password2'])) { echo $errors['password2']; } ?></span>

  <!-- SUBMIT -->
  <input class"go" type="submit" name="submitted" value="Envoyer">
</form>

<?php
include('inc/footer.php');

?>
