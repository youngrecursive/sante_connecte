<?php
session_start();
require('../inc/function.php');
require('../inc/pdo.php');

if(!isLoggedAdmin()) {
  header('Location: ../index.php');
  exit(); }

  //on récupère l'ID dans l'url pour afficher le vaccin a delete
    $errors=array();
    if(!empty($_GET['id']) && is_numeric($_GET['id'])){
      $id = $_GET['id'];
    } else {
      header('Location: 404.php');
    }
    //Si on a cliqué sur le lien supprimer, l'entrée disparait de la BDD
    $sql = "DELETE FROM vaccins
            WHERE id = :id";
    $query = $pdo->prepare($sql);
    $query->bindValue(':id',$id,PDO::PARAM_INT);
    $query->execute();

    header('Location: tables2.php');

include('inc/header.php');


include('inc/footer.php'); ?>
