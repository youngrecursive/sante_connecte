<!DOCTYPE html>
<html lang="fr" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="asset/css/reset.css">
    <link rel="stylesheet" href="asset/css/style.css">
    <title>Sante Connecte</title>
  </head>
  <body>
    <header>
      <nav>
        <ul>
          <li><a href="index.php">Home</a></li>
          <?php if(isLoggedAdmin()) { ?>
          <li><a href="admin/index.php">Admin</a></li>
          <?php } ?>
          <?php if(isLoggedUser() || isLoggedAdmin()) { ?>
            <li>Bonjour <?= $_SESSION['user']['pseudo'] ?></li>
            <li><a href="user_see_vacs.php">Mon carnet de vaccination</a></li>
            <li><a href="user_profil.php">Mon profil</a></li>
            <li><a href="logout.php">Deconnexion</a></li>
          <?php } else { ?>
            <li><a href="register.php">Inscription</a></li>
            <li><a href="login.php">Connexion</a></li>
          <?php } ?>
          <li><a href="contact.php">Contact</a></li>
          <li><a href="mentions.php">Mentions</a></li>
        </ul>
      </nav>
    </header>
    <section>
