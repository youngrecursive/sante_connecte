<?php session_start(); ?>
<?php require('../inc/function.php'); ?>
<?php require('../inc/pdo.php'); ?>

<?php if(!isLoggedAdmin()) {
  header('Location: ../index.php');
  exit(); } ?>

<?php include('inc/header.php'); ?>

<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Blank Page</h1>

</div>

<?php include('inc/footer.php'); ?>
