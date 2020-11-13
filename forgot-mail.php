<?php

require('inc/pdo.php');
require('inc/function.php');

if (empty($_GET['id'])) {
  die('404');
}

if (!empty($_GET['id']) && is_numeric($_GET['id'])){
  $id = $_GET['id'];
  $sql = "SELECT * FROM nf_users WHERE id = '$id'";
  $query = $pdo->prepare($sql);
  $query->execute();
  $user = $query->fetch();

  if(!empty($user)) { ?>

    <p>Un mail vient de vous être envoyé, veuillez cliquer dessus pour choisir votre nouveau mot de passe</p>
    <a href="forgot_send_mail.php?id=<?= $user['id'] ?>">Recevoir de nouveau le mail</a>

    <h1>MAIL</h1>
    <div class="">
      Bonjour <?= $user['prenom'] ?> Voici le lien vous permettant de créer un nouveau mot de passe. A l'avenir, pensez à la conserver préciseusement.
      <a href="forgot_new_pass.php?id=<?= $user['token'] ?>">Lien</a>
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
