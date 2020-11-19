<?php

require('inc/pdo.php');
require('inc/function.php');
include('inc/header.php');

if (empty($_GET['id'])) {
  header('Location: 404.php');
  exit();
}

else {
  $token = $_GET['id'];
  $sql = "SELECT * FROM nf_users WHERE token = '$token'";
  $query = $pdo->prepare($sql);
  $query->execute();
  $user = $query->fetch();

  if(!empty($user)) { ?>


    <section id="section1-mail" class="format">
      <div class="form">
        <p>Un mail vient de vous être envoyé, veuillez cliquer dessus pour choisir votre nouveau mot de passe
          <a href="forgot_send_mail.php?id=<?= $user['id'] ?>">Recevoir de nouveau le mail</a></p><br>

   <p>Bonjour <?= $user['prenom'] ?> Voici le lien vous permettant de créer un nouveau mot de passe. A l'avenir, pensez à la conserver préciseusement.
              <a href="forgot_new_pass.php?id=<?= $user['token'] ?>">Lien</a></p>



      </div>
  </section>
  <?php }

  else{
    header('Location: 404.php');
    exit();
  }
}


include('inc/footer.php');
