<?php
// connexion
session_start();
include('inc/pdo.php');
include('inc/function.php');
$errors = array();

// Si success est true, on affiche un msg de bienvenu, sinon c'est que l'user n'est pas nouveau.
$success = false;
// Ci dessous on récupère le token qui est généré seulement au moment où le compte utilisateur est validé via le mail
if (!empty($_GET)) {
  $token2 = $_GET['id'];
}


// CI DESSOUS ON VERIFIE SI C LA PREMIERE VENUE DE USER
if(!empty($token2)){
  $token2 = cleanXss($token2);
  $sql = "SELECT * FROM nf_users WHERE token2 = '$token2'";
  $query = $pdo->prepare($sql);
  $query->execute();
  $firstuser = $query->fetch();

  if (!empty($firstuser)) {
    $success = true;
  }
  else {
    header('Location: login.php');
    die();
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

          // Si c'est un nouvel user, au moment de la connexion il n'aura plus de token2 donc il ne verra plus de message de bienvenue par la suite...
          if(!empty($token2) && !empty($user['token2']) && $token2 = $user['token2']) {
            $sql = "UPDATE nf_users SET token2 = NULL WHERE token2 = '$token2'";
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
            die();
          }
          elseif($user['role'] == 'admin') {
            $_SESSION['user'] = array(
            'id'     => $user['id'],
            'pseudo' => $user['email'],
            'role'   => $user['role'],
            'ip'     => $_SERVER['REMOTE_ADDR'] // ::1
            );

            header('Location: index.php');
            die();
          }

          elseif($user['role'] == 'user_novalid'){
            $errors['email'] = 'Veuillez valider votre compte via le lien que nous vous avons communiqué par mail <br> Vous ne l\'avez pas reçu ? <a href="valid_register.php?id='. $user['token'].'">Cliquez ici</a>';
          }

          else {
            die('404');
          }


        }
        else {
          $errors['email'] = 'ERROR CREDENTIAL';
        }

      }

      else {
        $errors['email'] = 'ERROR CREDENTIAL';
      }
    }

  else {
    $errors['email'] = 'Veuillez renseigner les champs';
  }

}


include('inc/header.php'); ?>
<h1>Connexion</h1>



  <?php
    if (!empty($success)) { ?>
      <div class="">
        Bonjour, votre compte a bien été validé. Vous pouvez dès à présent vous connecter et accéder à votre espace personnel.
      </div>

    <?php }
   ?>
  <form action="" method="post">
    <!-- LOGIN -->
    <div class="">
      <label for="email">Email</label>
      <span class="error"><?php if(!empty($errors['email'])) { echo $errors['email']; } ?></span>
      <input type="text" id="email" name="email" value="<?php if(!empty($_POST['email'])) { echo $_POST['email']; } ?>">
    </div>

    <!-- PASSWORD -->
    <div class="">
      <label for="password">Mot de passe*</label>
      <input type="password" name="password" id="password" class="form-control" value="" />
    </div>

    <input type="submit" name="submitted" value="Connexion" />

  </form>
  <a href="forgot_form_auth.php">Mot de passe oublié ?</a>

<?php include('inc/footer.php');
