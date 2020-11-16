<?php

require('inc/pdo.php');
require('inc/function.php');
require('inc/function_mail.php');


if (!empty($_GET['id'])){
  $token = $_GET['id'];
  $token = cleanXss($token);
  $sql = "SELECT * FROM nf_users WHERE token = '$token'";
  $query = $pdo->prepare($sql);
  $query->execute();
  $user = $query->fetch();

  if(!empty($user)) {

    $sql = "UPDATE nf_users SET token_at = NOW() WHERE token = '$token'";
    $query = $pdo->prepare($sql);
    $query->execute();

    /* Ici un user qui est en train de valider son compte
     pourrait accéder à cette page avec le token de son lien de validation
     inscription mais cela importe peu puisque
     le fait de réinitialiser son mot de passe permet de valider son compte */

    $dotenv = Dotenv\Dotenv::createUnsafeImmutable(__DIR__);
    $dotenv->load();

    // Ici on utilise $_SERVER pour que le lien marche chez tout le monde en dev
    $link = '<a href="http://localhost'.dirname($_SERVER['PHP_SELF']).'/forgot_new_pass.php?id='. $user['token'].'">Lien</a>';


    $mailexpediteur = getenv('COMP_MAIL');
    $passwordmail = getenv('MAIL_PASS');
    $mailrecepteur = getenv('PERSO_MAIL');
    $object = 'Votre nouveau mot de passe';
    $message = 'Veuillez cliquer sur ce '.$link.' afin de choisir un nouveau mot de passe';


    sendMailer($mailexpediteur,$passwordmail,$mailrecepteur,$object,$message);


    header('Location: forgot-mail.php?id='.$user['token'].'');
    exit();
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
