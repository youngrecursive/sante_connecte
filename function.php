<?php
function debug($tableau)
{
  echo '<pre>';
  print_r($tableau);
  echo '</pre>';
}

function recupImg($film)
{
  return '<img src="http://www.weblitzer.fr/formation/posters/'.$film['id'].'.jpg" alt="'.$film['title'].'">';
}
