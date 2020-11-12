<?php

require('inc/pdo.php');
require('inc/function.php');

if (!empty($_GET['id'])){
  $token = $_GET['id'];
  $sql = "SELECT * FROM nf_users WHERE token = '$token'";
  $query = $pdo->prepare($sql);
  $query->execute();
  $user = $query->fetch();

  if(!empty($user)) { ?>

    <p>Un mail vient de vous être envoyé, il comporte un lien permettant l'activation de votre compte</p>
    <a href="valid_register.php?id=<?= $user['token'] ?>">Recevoir de nouveau le mail</a>

    <h1>MAIL</h1>
    <div class="">
      Bonjour <?= $user['prenom'] ?>, votre demande de création de compte a bien été enregistré.
      Veuillez cliquer sur le lien ci-dessous afin de valider votre inscription.
      <a href="z_link_validate_user.php?id=<?= $user['token'] ?>">Lien</a>
    </div>
  <?php }

  else{
    die('404');
  }
}
else {
  die('404');
}

?>
