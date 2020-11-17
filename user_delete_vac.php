<?php
session_start();
require('inc/pdo.php');
require('inc/function.php');

// On vérifie maintenant que user est connecté, plus besoin de vérifier ensuite si $_SESSION existe

if(isLoggedUser() || isLoggedAdmin()) {

  if(!empty($_GET['id'])) {

    // ON RECUPERE 2 VALEURS DANS L'ULR AVEC CETTE TECHNIQUE PHP JAPONAISE
    $xplode = explode('/', $_GET['id']);
    $user_id = $xplode[0];
    $vaccin_id = $xplode[1];
    $id = $_SESSION['user']['id'];

    if(is_numeric($user_id) && is_numeric($vaccin_id)) {
      $sql = "DELETE FROM vaccins_user WHERE user_id = :user_id AND vaccin_id = :vaccin_id";
      $query = $pdo->prepare($sql);
      $query->bindValue(':user_id', $user_id,PDO::PARAM_INT);
      $query->bindValue(':vaccin_id', $vaccin_id,PDO::PARAM_INT);
      $query->execute();

      header('Location: user_see_vacs.php?id='.$id.'/delete');
      exit();
    }

    // ID PAS NUMERIQUE DONC FAUX
    else {
      header('Location: 404.php');
      exit();

    }


  }
  // ID EST VIDE DANS URL

    header('Location: 404.php');
    exit();
  }

// PAS CONNECTE
else {
  header('Location: 404.php');
  exit();
}















require('inc/header.php'); ?>


<?php


?>
<?php
include('inc/footer.php');
