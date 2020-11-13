<?php
require('inc/function.php');
session_start();

if(isLoggedUser() || isLoggedAdmin()) {
$_SESSION = array();
session_destroy();
header('Location: index.php');
}
else { ?>

  <div class="">
    Cette page n'est pas accessible.
  </div>
<?php }
