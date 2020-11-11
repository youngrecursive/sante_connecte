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


  if(!empty($user)) // && if (token_at < token_limit)
    {
    $sql = "UPDATE nf_users SET token = NULL, role = 'user' WHERE token = '$token'";
    $query = $pdo->prepare($sql);
    $query->execute();
    header('Location: login.php');
    exit();
   }

  else{
    die('404');
  }
}
else {
  die('404');
}

?>
