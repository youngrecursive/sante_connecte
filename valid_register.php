<?php

require('inc/pdo.php');
require('inc/function.php');

if (!empty($_GET['id'])){
  $token = $_GET['id'];
  $sql = "SELECT * FROM nf_users WHERE token = '$token'";
  $query = $pdo->prepare($sql);
  $query->execute();
  $user = $query->fetch();

  if(!empty($user)) {
    $newtoken = generateRandomString(120);
    $sql = "UPDATE nf_users SET token = '$newtoken', token_at = NOW() WHERE token = '$token'";
    $query = $pdo->prepare($sql);
    $query->execute();

     ?>
    <div class="">Bonjour <?= $user['prenom'] ?>, un lien de confirmation vient de vous être envoyé par email.
    </div>
    <a href="z_mail_inscription.php?id=<?= $newtoken ?>">Voir le mail</a>
  <?php }

  else{
    die('404');
  }
}
else {
  die('404');
}

?>
