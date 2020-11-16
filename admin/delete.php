<?php session_start(); ?>
<?php require('../inc/function.php'); ?>
<?php require('../inc/pdo.php'); ?>

<?php if(!isLoggedAdmin()) {
  header('Location: ../index.php');
  exit(); } ?>

<?php include('inc/header.php');

// <!-- SUPPRESSION VACCINS_USER -->


$sql = "DELETE FROM vaccins_user WHERE id = :id";
$query = $pdo->prepare($sql);
$query->bindValue(':id', $_GET['m'],PDO::PARAM_INT);
$query->execute();
if(!$query) {
  if confirm('Etes-vous sur de vouloir supprimer ?') {
  return true;
  }
  else {
  return false;
  }

 include('inc/footer.php'); ?>
