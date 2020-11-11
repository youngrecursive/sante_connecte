<?php
// VISIBLE SEULEMENT POUR USERS CONNECTES ET VALIDES
session_start();
include('inc/pdo.php');
include('inc/function.php');
include('inc/header.php'); ?>

<?php if(isLoggedUser() || isLoggedAdmin()) { ?>


<div class="wrap">
  <p>Mon profil</p>
</div>


<?php }
else {
  die('Accès refusé');
}
 ?>
<?php
include('inc/footer.php');
