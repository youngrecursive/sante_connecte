<?php
session_start();
require('../inc/function.php');
require('../inc/pdo.php');

if(!isLoggedAdmin()) {
  header('Location: ../index.php');
  exit(); }


//on récupère l'ID dans l'url
  $errors=array();
  if(!empty($_GET['id']) && is_numeric($_GET['id'])){
    $id = $_GET['id'];
    //fetch le vaccin dans la BDD
  }
  $sql = "SELECT * FROM vaccins WHERE id = :id";
  $query = $pdo->prepare($sql);
  $query->bindValue(':id',$id,PDO::PARAM_INT);
  $query->execute();
  $vaccins = $query->fetch();

include('inc/header.php'); ?>
<!-- on utilise les données qu'on a fetch et on les affiches -->
  <div class="container-fluid">
    <h1>Détails</h1>
    <p>Nom du vaccin: <?= $vaccins['nomvaccin'];?></p>
    <p>Description : <?= $vaccins['description'];?></p>
    <p><?= $vaccins['nombrerappel'];?> rappels à effectuer.</p>
    <p>Un rappel tous les <?= $vaccins['intervallerappel'];?> mois à effectuer</p>
    <!-- boutton back stylisé via boostrap -->
    <div class="my-2"></div>
    <a href="new_vaccine.php" class="btn btn-light btn-icon-split">
        <span class="icon text-gray-600">
            <i class="fas fa-arrow-right"></i>
        </span>
        <span class="text">Retourner sur la table des vaccins</span>
  </div>


<?php include('inc/footer.php'); ?>
