<!DOCTYPE html>
<html lang="fr" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/x-icon" href="asset/img/logo.png" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="asset/css/reset.css">
    <link rel="stylesheet" href="asset/css/style.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Overpass:wght@800&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Merriweather&family=Oswald&display=swap" rel="stylesheet">
    <title>Sante Connecte</title>
  </head>
  <body>
    <header id="header">
      <div class="wrap_header">
        <div class="menu">

          <a href="index.php">
            <div class="logo">

            </div>

          </a>
          <nav>
            <ul>
              <li class="underline"><a href="index.php">Home</a></li>
              <li class="underline"><a href="contact.php">Contact</a></li>
              <li class="underline"><a href="mentions.php">Mentions</a></li>
              <?php if(isLoggedAdmin()) { ?>
                <li class="underline"><a href="admin/index.php">Admin</a></li>
              <?php } ?>
              <?php if(isLoggedUser() || isLoggedAdmin()) { ?>
                <li>Bonjour <?= $_SESSION['user']['pseudo'] ?></li>
                <li class="submenu"><a href="#">mes activités</a>
                  <ul>
                    <li><a href="user_see_vacs.php?id=<?= $_SESSION['user']['id']?>">
                      <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16c0 1.1.9 2 2 2h12a2 2 0 0 0 2-2V8l-6-6z"/><path d="M14 3v5h5M16 13H8M16 17H8M10 9H8"/></svg>

                      &nbsp;Mon carnet de vaccination</a></li>
                    <li><a href="user_profil.php?id=<?= $_SESSION['user']['id'] ?>">
                      <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>

                      &nbsp;Mon profil</a></li>
                    <li class="logout"><a href="logout.php">
                      <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>

                       &nbsp;Deconnexion</a></li>
                  </ul>
                </li>
              <?php } else { ?>
                <li class="underline"><a href="register.php">Inscription</a></li>
                <li class="underline"><a href="login.php">Connexion</a></li>
              <?php } ?>
            </ul>
          </nav>
        </div>
        <div class="menuresponsive1">

          <a href="index.php">
            <div class="logo">

            </div>

          </a>
          <nav>
            <input id="menu-checkbox" type="checkbox" class="menu-checkbox" />
            <label for="menu-checkbox" class="menu-toggle">≡ menu</label>
            <ul class="menu">
              <li><a href="index.php">Home</a></li>
              <?php if(isLoggedAdmin()) { ?>
                <li><a href="admin/tables.php">Admin</a></li>
              <?php } ?>
              <?php if(isLoggedUser() || isLoggedAdmin()) { ?>
                <li class="carnet"><a href="user_see_vacs.php?id=<?= $_SESSION['user']['id']?>">
                      <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16c0 1.1.9 2 2 2h12a2 2 0 0 0 2-2V8l-6-6z"/><path d="M14 3v5h5M16 13H8M16 17H8M10 9H8"/></svg>

                      &nbsp;Mon carnet</a></li>
                <li class="carnet"><a href="user_profil.php?id=<?= $_SESSION['user']['id'] ?>">
                      <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>

                      &nbsp;Mon profil</a></li>
                <li class="logout"><a href="logout.php">
                      <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>

                       &nbsp;Deconnexion</a></li>
              <?php } else { ?>
                <li><a href="register.php">Inscription</a></li>
                <li><a href="login.php">Connexion</a></li>
              <?php } ?>
            </ul>
          </nav>
        </div>
      </div>
    </header>
