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
