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
  if($sql == true){
    echo '<div class="alert alert-success">Votre requête a bien été effectuée !</div>'; ?>
    <a href="tables.php" title="Précédent">Précédent</a>
    <?php
  }
} ?>



 <?php include('inc/footer.php');
