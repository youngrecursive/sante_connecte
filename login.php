<?php
// connexion
session_start();
include('inc/pdo.php');
include('inc/function.php');
$errors = array();
$flash = array();

// Si success est true, on affiche un msg de bienvenu, sinon c'est que l'user n'est pas nouveau ou qu'il ne vient pas de reset son password.
$success = false;
// Ci dessous on récupère le token qui est généré seulement au moment où le compte utilisateur est validé via le mail



// CI DESSOUS ON VERIFIE SI C LA PREMIERE VENUE DE USER OU SI IL VIENT DE CHANGER DE MOT DE PASSE
// SI AUCUN DES 2 ALORS ON LE REDIRIGE VERS LA PAGE STANDARD...
if(!empty($_GET)){

  $token = $_GET['id'];
  $token = cleanXss($token);
  $sql = "SELECT * FROM nf_users WHERE token2 = '$token' OR token3 ='$token'";
  $query = $pdo->prepare($sql);
  $query->execute();
  $firstuser = $query->fetch();

  if (!empty($firstuser)) {
    $sql = "SELECT * FROM nf_users WHERE token2 = '$token'";
    $query = $pdo->prepare($sql);
    $query->execute();
    $firstuser = $query->fetch();
    if(!empty($firstuser)){
      $success = true;
      $flash['message'] = 'Bienvenue sur Vacbook. Vous pouvez maintenant accéder à votre espace personnel.';
    }
    else {
      $sql = "SELECT * FROM nf_users WHERE token3 = '$token'";
      $query = $pdo->prepare($sql);
      $query->execute();
      $firstuser = $query->fetch();
      if(!empty($firstuser)){
        $success = true;
        $flash['message'] = 'Votre mot passe a bien été modifié. Vous pouvez accéder de nouveau à votre espace personnel.';
      }
    }
  }
  else {
    header('Location: login.php');
    exit();
  }
}



if(!empty($_POST['submitted'])) {
  $email    = cleanXss($_POST['email']);
  $password = cleanXss($_POST['password']);

  if(!empty($email && $password)){
      $sql = "SELECT * FROM nf_users WHERE email = :email";
      $query = $pdo->prepare($sql);
      $query->bindValue(':email',$email,PDO::PARAM_STR);
      $query->execute();
      $user = $query->fetch();

      if(!empty($user)){
        $hashpassword = $user['password'];
        if(password_verify($password,$hashpassword)){

          // Que l'user vienne de reset mot de passe ou que ce soit sa première venue on reset token 2 et 3
          if(!empty($token)) {
            if($token == $user['token2'] || $token == $user['token3'])
            $sql = "UPDATE nf_users SET token2 = NULL, token3 = NULL WHERE token2 = '$token' OR token3 = '$token'";
            $query = $pdo->prepare($sql);
            $query->execute();
          }
          // Même si la condition ci-dessus n'est pas toujours valable les choses se dérouleront de la même manière ci-dessous...

          if($user['role'] == 'user') {
            $_SESSION['user'] = array(
            'id'     => $user['id'],
            'pseudo' => $user['email'],
            'role'   => $user['role'],
            'ip'     => $_SERVER['REMOTE_ADDR'] // ::1
            );

            header('Location: index.php');
            exit();
          }
          elseif($user['role'] == 'admin') {
            $_SESSION['user'] = array(
            'id'     => $user['id'],
            'pseudo' => $user['email'],
            'role'   => $user['role'],
            'ip'     => $_SERVER['REMOTE_ADDR'] // ::1
            );

            header('Location: index.php');
            exit();
          }

          elseif($user['role'] == 'user_novalid'){
            $errors['email'] = 'Veuillez valider votre compte via le lien que nous vous avons communiqué par mail <br> Vous ne l\'avez pas reçu ? <a href="valid_register.php?id='. $user['token'].'">Cliquez ici</a>';
          }

          else {
            header('Location: 404.php');
            exit();
          }


        }
        else {
          $errors['email'] = 'ERREUR';
        }

      }

      else {
        $errors['email'] = 'ERREUR';
      }
    }

  else {
    $errors['email'] = 'Veuillez renseigner les champs';
  }

}


include('inc/header.php'); ?>
<section id="section1-login">


  <?php
    if (!empty($success)) { ?>
      <div class="">
        <?= $flash['message']; ?>
      </div>

    <?php }
   ?>
  <form action="" method="post">
    <h1>Connexion</h1>
    <!-- LOGIN -->
    <div class="email">
      <label for="email">Email : </label><br>
      <input placeholder="Michel.Dupont@vacbook.fr" type="text" id="email" name="email" value="<?php if(!empty($_POST['email'])) { echo $_POST['email']; } ?>">
      <span class="error"><br><?php if(!empty($errors['email'])) { echo $errors['email']; } ?></span>
    </div>

    <!-- PASSWORD -->
    <div class="password">
      <label for="password">Mot de passe : </label><br>
      <input placeholder="Mot de passe" type="password" name="password" id="password" class="form-control" value="" />
    </div>

    <input type="submit" name="submitted" value="Connexion" class="submit"/>

  </form>

</section>

  <a href="forgot_form_auth.php">Mot de passe oublié ?</a>


<?php include('inc/footer.php');
