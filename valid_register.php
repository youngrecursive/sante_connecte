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


  // On verifie que l'user n'est pas déjà validé car il peut très bien avoir un token généré via le mot de passe oublié et avoir le rôle user or il n'a pas à avoir accès à ça
  if(!empty($user) && $user['role'] == 'user_novalid') {

    // UPDATE TOKEN_AT
    $sql = "UPDATE nf_users SET token_at = NOW() WHERE token = '$token'";
    $query = $pdo->prepare($sql);
    $query->execute();

    $dotenv = Dotenv\Dotenv::createUnsafeImmutable(__DIR__);
    $dotenv->load();

    // Ici on utilise $_SERVER pour que le lien marche chez tout le monde en dev
    $link = '<a href="http://localhost'.dirname($_SERVER['PHP_SELF']).'/z_link_validate_user.php?id='. $user['token'].'">Lien</a>';

    $date = New DateTime("now");
    $date->add(new DateInterval('PT3M'));

    $mailexpediteur = getenv('COMP_MAIL');
    $passwordmail = getenv('MAIL_PASS');
    $mailrecepteur = getenv('PERSO_MAIL');
    $object = 'Création de votre compte';
    $message = 'Veuillez cliquer sur ce '.$link.' pour valider votre compte<br>Attention, le lien expire le '.$date->format('d-m-Y à H:i:s').'';


    sendMailer($mailexpediteur,$passwordmail,$mailrecepteur,$object,$message);


    header('Location: z_mail_inscription.php?id='.$token.'');
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
