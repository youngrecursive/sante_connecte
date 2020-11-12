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

  if(!empty($user)) {

    // UPDATE TOKEN_AT
    $sql = "UPDATE nf_users SET token_at = NOW() WHERE token = '$token'";
    $query = $pdo->prepare($sql);
    $query->execute();


    // ENVOIE DU MAIL AVEC LES INFOS DU USER CONCERNE


    header('Location: z_mail_inscription.php?id='.$token.'');
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
