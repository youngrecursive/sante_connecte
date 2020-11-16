<?php


require('inc/pdo.php');
require('inc/function.php');


if (!empty($_GET['id'])){
  $token = $_GET['id'];
  $token = cleanXss($token);
  $sql = "SELECT * FROM nf_users WHERE token = '$token'";
  $query = $pdo->prepare($sql);
  $query->execute();
  $user = $query->fetch();





  // On vérifie que l'user n'est pas encore validé
  if(!empty($user) && $user['role'] == 'user_novalid')
    {
      // Ici on doit récupérer $user['token_at'] et déterminer au bout de combien de temps le lien n'est plus valide.
      $now = New DateTime("now");
      $tokenlimit = New DateTime($user['token_at']);
      $tokenlimit->add(new DateInterval('PT1M'));
      //$tokenlimit->add(new DateInterval('PT4H'));
      if($now < $tokenlimit == true) {
        // Token2 permet d'identifier un utilisateur qui se connecte pour la première fois
        $token2 = generateRandomString(120);
        $sql = "UPDATE nf_users SET token = NULL, token2 = '$token2', role = 'user' WHERE token = '$token'";
        $query = $pdo->prepare($sql);
        $query->execute();


        header('Location: login.php?id='.$token2.'');
        exit();
      }
      else {
        include('inc/header.php'); ?>
          <p>Le lien de validation a expiré...</p>
          <p>Pour obtenir un nouveau lien, veuillez renseigner votre adresse mail et mot de passe<a href="valid_register.php?id=<?= $user['token'] ?>">ICI</a></p>
          <p>Mot de passe oublié ? <a href="forgot_form_auth.php">Demander un nouveau mot de passe</a></p>
        <?php
        include('inc/footer.php');
      }
   }

  else{
    header('Location: 404.php');
    exit();
  }
}
else {
  header('Location: 404.php');
  exit();
}

?>
