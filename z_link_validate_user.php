<?php


require('inc/pdo.php');
require('inc/function.php');


if (!empty($_GET['id'])){
  $token = $_GET['id'];
  $sql = "SELECT * FROM nf_users WHERE token = '$token'";
  $query = $pdo->prepare($sql);
  $query->execute();
  $user = $query->fetch();

  // Ici on doit récupérer $user['token_at'] et déterminer au bout de combien de temps le lien n'est plus valide.
  $now = New DateTime("now");
  $tokenlimit = New DateTime($user['token_at']);
  $tokenlimit->add(new DateInterval('PT1M'));
  //$tokenlimit->add(new DateInterval('PT4H'));


  if(!empty($user))
    {
      if($now < $tokenlimit == true) {
        $sql = "UPDATE nf_users SET token = NULL, role = 'user' WHERE token = '$token'";
        $query = $pdo->prepare($sql);
        $query->execute();

        //echo $now->format('Y-m-d H:i:s');
        //echo '<br>';
        //echo $tokenlimit->format('Y-m-d H:i:s');
        header('Location: login.php');
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
