<?php
require('inc/function.php');
session_start();

if(isLoggedUser() || isLoggedAdmin()) {
$_SESSION = array();
session_destroy();
header('Location: index.php');
}
else {
  header('Location: 404.php');
  exit();
}
