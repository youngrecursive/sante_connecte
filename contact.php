<?php
session_start();
require('inc/function.php');
include('inc/header.php'); ?>


<section id="contact">
  <div class="wrapcontact">
        <h3>Vacbook Campus St Marc</h3>

      <div class="content1">
        <p> Vous souhaitez nous contacter ? Nous sommes disponibles au Campus St Marc ! 24 Place Saint-Marc, 76000 Rouen ouvert de 8h à 18h30, du lundi au vendredi. </p>
        <p> Numéro de téléphone : 02 32 10 25 01</p>
        <p>Disponible également en visio-conférence</p>
      </div>

      <div class="content2">
        <h3> Contacter le Webmaster</h3>
        <p>Si vous souhaitez contacter le webmaster, vous pouvez le contacter à l'adresse suivante </p>
        <a class="liencontact" href="#">Azad Nguyen</a>
      </div>

      <div class="content3">
        <h3>Nous écrire par mail</h3>
        <p>Si vous souhaitez contacter l'équipe en charge de la gestion des vaccins, veuillez cliquer ici </p>
        <a href="#">Vacbook@hotmail.fr</a>
    </div>

  <p class="textinto">Si vous voulez nous partager une information directement, veuillez remplir ce formulaire</p>

  <form  action="message" method="post">
    <div class="w50">
      <label for="name">Votre nom</label>
      <input class="inputerror" type="text" name="name" value="" placeholder="Nom">
    </div>
    <div class="w100">
        <label class="w100label" for="message">Votre message</label>
        <textarea class="placeholderA" name="message" rows="8" cols="55" placeholder="Je m'exprime"></textarea>
    </div>
<div class="boutonAz">
<ul>
<li><a class="clic" href="#">Envoyer</a></li>

  <!-- <input class="envoi" type="submit" name="submit" value="Envoyer"> -->
</ul>



</div>


  </form>
  </div>
  </section>
<?php
include('inc/footer.php');
