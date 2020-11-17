<?php session_start(); ?>
<?php require('../inc/function.php'); ?>
<?php require('../inc/pdo.php'); ?>

<?php if(!isLoggedAdmin()) {
  header('Location: ../index.php');
  exit(); } ?>

<?php include('inc/header.php');

// <!-- SUPPRESSION VACCINS_USER -->
$errors = array();
if(count($errors) == 0) {
  $sql = "DELETE FROM nf_users WHERE id = :id";
  $query = $pdo->prepare($sql);
  $query->bindValue(':id', $_GET['id'],PDO::PARAM_INT);
  $query->execute();

        header('Location: tables.php');
        die();
 }

 include('inc/footer.php'); ?>
