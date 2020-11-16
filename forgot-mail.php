<?php

require('inc/pdo.php');
require('inc/function.php');
include('inc/header.php');

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

    <section id="section1-mail">
      <div class="block">
        <p>Un mail vient de vous être envoyé, veuillez cliquer dessus pour choisir votre nouveau mot de passe
          <br><a href="forgot_send_mail.php?id=<?= $user['id'] ?>">Recevoir de nouveau le mail</a></p>

          <!-- <h1>MAIL</h1> -->
          <div class="">
            <p>Bonjour <?= $user['prenom'] ?> Voici le lien vous permettant de créer un nouveau mot de passe. A l'avenir, pensez à la conserver préciseusement.
              <br><a href="forgot_new_pass.php?id=<?= $user['token'] ?>">Lien</a></p>
            </div>

      </div>
  </section>
  <?php }

  else{
    die('404');
  }
}
else {
  die('404');
}

include('inc/footer.php');
