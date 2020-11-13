<?php

require('inc/pdo.php');
require('inc/function.php');

if (!empty($_GET['id']) && is_numeric($_GET['id'])){
  $id = $_GET['id'];
  $sql = "SELECT * FROM nf_users WHERE id = '$id'";
  $query = $pdo->prepare($sql);
  $query->execute();
  $user = $query->fetch();

  if(!empty($user)) {

    $token = generateRandomString(120);
    $sql = "UPDATE nf_users SET token = '$token', token_at = NOW() WHERE id = '$id'";
    $query = $pdo->prepare($sql);
    $query->execute();


    // ENVOIE DU MAIL AVEC LES INFOS DU USER CONCERNE


    header('Location: forgot-mail.php?id='.$id.'');
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
