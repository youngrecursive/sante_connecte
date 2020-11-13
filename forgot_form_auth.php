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
       header('Location: forgot_send_mail.php?id='.$user['id'].'');
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

<form action="" method="post">
  <!-- EMAIL -->
  <div class="">
    <label for="email">Email</label>
    <input type="text" id="email" name="email" value="<?php if(!empty($_POST['email'])) { echo $_POST['email']; } ?>">
    <span class="error"><?php if(!empty($errors['email'])) { echo $errors['email']; } ?></span>
  </div>

  <input type="submit" name="submitted" value="Envoyer" />

</form>

<?php include('inc/footer.php'); ?>
