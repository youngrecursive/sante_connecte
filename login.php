<?php
// connexion
session_start();
include('inc/pdo.php');
include('inc/function.php');
$errors = array();
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

<?php include('inc/footer.php');
