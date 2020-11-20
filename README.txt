Vacbook (PHP)
Grouoe 3
Azad, Théo, Benjamin, Basile, Taïr (Pape)

README structuré en 2 parties.
  I/ Guide pour faire fonctionner le site
  II/ Technologies


I/ Guide pour faire fonctionner le site


  1) SERVEUR PHP ET MY SQL DOIT ETRE OUVERT AFIN D'AFFICHER LE SITE

  2) Pour faire fonctionner le template admin, télécharger SB Admin 2.
  https://github.com/startbootstrap/startbootstrap-sb-admin-2/archive/gh-pages.zip
  Remplacé le dossier récupéré via github par le dossier téléchargé, à la racine du dossier admin.

  + Créer un fichier pdo.php dans le dossier inc
  Il doit contenir :


  ```
  <?php
    try {
      $pdo = new PDO('mysql:host=localhost;dbname=namedatabase', "root", "", array(
          PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
          PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
          PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING
      ));
    }
    catch (PDOException $e) {
      echo 'Erreur de connexion : ' . $e->getMessage();
    }

  ````
    

  3) Composer doit être installé sur votre ordinateur afin de faire fonctionner des dépendances.
  https://getcomposer.org/


  4) Une fois composer installé,

  TAPER DANS CMD A LA RACINE DU PROJET
  composer require phpmailer/phpmailer
  composer require vlucas/phpdotenv

  5/ Si pas de .env fonctionnel (lignes à commenter)

    Il est nécessaire  de commenter certaines choses dans :

    forgot_send_mail (racine du site)
        de ligne 27 à 43 (la fonction sendMail ainsi que l'objet dotenv)

    validate_register (racine du site)
        de ligne 25 à 41


    register.php (racine du site)
        de ligne 64 à 70 commenter le if.
        de ligne 71 à 74, enlever juste les écritures "else"
        afin d'éxecuter le code sans conditions


  6) ENJOY



II/ Technologies

1) Langages

  Notre site est codé en PHP, HTML, MYSQL et CSS
  L'intérêt principal étant de générer dynamiquement du html selon nos variables, nos requêtes sql, etc...

2) Serveur local

  PHP SERVEUR = Apache (XAMPP)
  BASE DE DONNEES = MYSQL (XAMPP)


3) DEPENDANCE

  Php Mailer = Permet d'instancier des objets qui envoient des mails.
  Php Dotenv = Permet d'instancier des objets qui font appel à un fichier .env
    le fichier .env permet de stocker de manière sécurisée des variables serveurs que l'on peut appeler partout
    dans notre site. Dans notre cas il est ignoré sur git, la solution aurait pu être de faire un env.local



4) Structure et code

  Le site est séparé en 2, un côté admin et un côté user.
  Dans les 2 cas, le header et footer sont contenus dans un seul fichier qui sera appelé
  quand la page contient du html.

  Il y a un fichier css pour le côté admin et un fichier css pour le côté user.
  Pour l'admin, un template boostrap (sb admin2) est utilisé.
  Il permet d'obtenir un rendu responsive rapide.

  La plupart du code est tapé de manière procédurale pour le php.
  Cependant les dépendances composer et les dates font que certains objets sont utilisés dans le code.

  Toutes les fonctions utilisées dans notre code sont stockées dans un fichier function.php qui est commun
  au front et back.
