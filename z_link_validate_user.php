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






  if(!empty($user))
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

        //echo $now->format('Y-m-d H:i:s');
        //echo '<br>';
        //echo $tokenlimit->format('Y-m-d H:i:s');
        header('Location: login.php?id='.$token2.'');
        exit();
      }
      else {
        die('Le lien de validation a expiré.');
      }

   }

  else{
    die('Erreur 404');
  }
}
else {
  die('404');
}

?>
