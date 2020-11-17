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





include('inc/header.php'); ?>


<?php include('inc/footer.php'); ?>
