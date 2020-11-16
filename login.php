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
<section id="section1-login">


  <?php
    if (!empty($success)) { ?>
      <div class="">
        Bonjour, votre compte a bien été validé. Vous pouvez dès à présent vous connecter et accéder à votre espace personnel.
      </div>

    <?php }
   ?>
  <form action="" method="post">
    <h1>Connexion</h1>
    <!-- LOGIN -->
    <div class="email">
      <label for="email">Email : </label>
      <input placeholder="Email" type="text" id="email" name="email" value="<?php if(!empty($_POST['email'])) { echo $_POST['email']; } ?>">
      <span class="error"><br><?php if(!empty($errors['email'])) { echo $errors['email']; } ?></span>
    </div>

    <!-- PASSWORD -->
    <div class="password">
      <label for="password">Mot de passe : </label>
      <input placeholder="Mot de passe" type="password" name="password" id="password" class="form-control" value="" />
    </div>

    <input type="submit" name="submitted" value="Connexion" class="submit"/>

  </form>

</section>
<section id="section2-login">
  <div class="box box1">
    <p class="titre">
      <svg xmlns="http://www.w3.org/2000/svg" width="29" height="29" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="8.5" cy="7" r="4"></circle><line x1="18" y1="8" x2="23" y2="13"></line><line x1="23" y1="8" x2="18" y2="13"></line></svg>
      <span>Mot de passe oublié ?</span>
    </p>
    <p class="text">Si tu as oubliés ton mot de passe pas de panique tu as juste à
      <a href="forgot_form_auth.php">cliquer ici.</a>
    </p>

  </div>
  <div class="box box2">
    <p class="titre">
      <svg xmlns="http://www.w3.org/2000/svg" width="29" height="29" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="8.5" cy="7" r="4"></circle><line x1="20" y1="8" x2="20" y2="14"></line><line x1="23" y1="11" x2="17" y2="11"></line></svg>
      <span>Pas encore Inscrit</span>
    </p>
    <p class="text">Si tu n'es pas encore inscrit, tu peux t'inscrire en
      <a href="register.php">cliquant ici.</a>
    </p>
  </div>

</section>


<?php include('inc/footer.php');
