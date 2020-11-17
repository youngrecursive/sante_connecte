<?php
session_start();
require('../inc/pdo.php');
require('../inc/function.php');

// On vérifie maintenant que user est connecté, plus besoin de vérifier ensuite si $_SESSION existe
 include('inc/header.php');
if(isLoggedAdmin()) {

  if(!empty($_GET['id'])) {

    // ON RECUPERE 2 VALEURS DANS L'ULR AVEC CETTE TECHNIQUE PHP JAPONAISE
    $xplode = explode('/', $_GET['id']);
    $user_id = $xplode[0];
    $id = $_SESSION['user']['id'];

    $sql = "SELECT id FROM vaccins WHERE nomvaccin = :nomvaccin";
    $query = $pdo->prepare($sql);
    $query->bindValue(':nomvaccin', $xplode[1],PDO::PARAM_STR);
    $query->execute();
    $vaccin_id = $query->fetchAll()[0]['id'];
    // debug($vaccin_id);


    if(is_numeric($user_id) && is_numeric($vaccin_id)) {
      $sql = "DELETE FROM vaccins_user WHERE user_id = :user_id AND vaccin_id = :vaccin_id";
      $query = $pdo->prepare($sql);
      $query->bindValue(':user_id', $user_id,PDO::PARAM_INT);
      $query->bindValue(':vaccin_id', $vaccin_id,PDO::PARAM_INT);
      $query->execute();
    }
  }
} ?>
    <h6>VOTRE REQUÊTE A BIEN ETE EFFECTUEE !</h6>
    <li><a href="details.php?id=<?= $user_id ?>" title="Précédent">Précédent</a></li>


 <?php include('inc/footer.php'); ?>
