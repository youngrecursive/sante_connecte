<?php


include('../../inc/pdo.php');
include('../../inc/function.php');
include('tables.php');
?>




<ul>
  <?php while($u = $users->fetch()) { ?>
  <li><?= $u['id'] ?> : <?= $u['nom'] ?> - <a href"tables.php?supprime=<?= $m['id'] ?>">Supprimer</a></li>
</ul>



//include('tables.php');
?>
