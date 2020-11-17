<?php
include('inc/pdo.php');
include('inc/function.php');
$errors = array();


 if(!empty($_POST['submitted'])) {
   $email    = cleanXss($_POST['email']);

   if(!empty($email)){
     $sql = "SELECT * FROM nf_users WHERE email = :email";
     $query = $pdo->prepare($sql);
     $query->bindValue(':email',$email,PDO::PARAM_STR);
     $query->execute();
     $user = $query->fetch();

     if(!empty($user)){
       $token = generateRandomString(120);
       $sql = "UPDATE nf_users SET token = '$token' WHERE email = '$email'";
       $query = $pdo->prepare($sql);
       $query->execute();

       header('Location: forgot_send_mail.php?id='.$token.'');
       exit();
     }

     else {
       $errors['email'] = 'Email introuvable...';
     }
   }

   else {
     $errors['email'] = 'Veuillez renseiger votre mail svp';
   }



}


include('inc/header.php'); ?>
<section id="section1-forgot" class="format">
  <form action="" method="post" class="form">
    <h1>Mot de passe oublié</h1>
        <h2>Si tu as perdues ton mot de passe saisit ton Email et un mail va t'étre envoyer pour pouvoirs réinitialiser ton mot de passe</h2>
    <!-- EMAIL -->
    <div class="">
      <label for="email">Email : </label>
      <input placeholder="Email" type="text" id="email" name="email" value="<?php if(!empty($_POST['email'])) { echo $_POST['email']; } ?>"><br>
      <span class="error"><?php if(!empty($errors['email'])) { echo $errors['email']; } ?></span>
    </div>

    <input class="submit" type="submit" name="submitted" value="Envoyer" />

  </form>

</section>

<?php include('inc/footer.php'); ?>
