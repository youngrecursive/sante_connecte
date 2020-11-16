<?php
function debug($array)
{
  echo '<pre>';
  print_r($array);
  echo '</pre>';
}


function cleanXss($value){
  return trim(strip_tags($value));
}




function validText($errors,$value,$key,$min,$max){
  if(!empty($value)) {
    if(mb_strlen($value) < $min) {
      $errors[$key] = 'Veuillez renseigner au moins ' .$min . ' caractères';
    } elseif(mb_strlen($value) > $max) {
      $errors[$key] =  'Veuillez renseigner moins de ' .$max . ' caractères';
    }
  } else {
    $errors[$key] = 'Veuillez renseigner ce champ';
  }

  return $errors;
}


function validTextNull($errors,$value,$key,$min,$max){
    if(mb_strlen($value) > 0 && mb_strlen($value) < $min) {
      $errors[$key] = 'Veuillez renseigner au moins ' .$min . ' caractères ou ne mettez rien';
    } elseif(mb_strlen($value) > $max) {
      $errors[$key] =  'Veuillez renseigner moins de ' .$max . ' caractères';
    }
  return $errors;
}


function validMail($errors,$value,$key){
  if(!empty($value)) {
    if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
    $errors[$key] = 'Ce mail n\'est pas valide';
    }

  }
  else {
    $errors[$key] = 'Veuillez renseigner ce champ';
  }

  return $errors;
}

function validPass($errors,$password1,$key1,$password2,$min,$max){
  if(!empty($password1 && $password2)) {
    if($password1 == $password2){
      if(mb_strlen($password1) < $min) {
        $errors[$key1] = 'Veuillez renseigner au moins' .$min . 'caractères';
      }
      elseif(mb_strlen($password1) > $max) {
        $errors[$key1] =  'Veuillez renseigner moins de ' .$max . 'caractères';
      }
    }
    else {
      $errors[$key1] = 'Veuilez renseigner le même mot de passe';
    }
  }
  else {
    $errors[$key1] = 'Veuillez remplir les champs password';
  }

  return $errors;
}

function validDate($errors,$value,$key){
  // PENSER A METTRE max="9999-12-31" comme attribut dans l'input date
  if(!empty($value)){
    $now = New DateTime("now");
    $datelimit = New DateTime("now");
    $datelimit->sub(new DateInterval('P120Y'));
    $date = New DateTime($value);


    $dateformate = $date->format('m-d-Y');
    $datexplode = explode('-', $dateformate);
    $month = $datexplode[0];
    $day = $datexplode[1];
    $year = $datexplode[2];

    if (checkdate($month, $day, $year) == true){
      if ($date < $datelimit == true) {
        $errors[$key] = 'Maître yoda vous n\'êtes pas...';
      }
      if ($date > $now == true) {
        $errors[$key] = 'Veuillez renseigner une date passée';
      }
    // SI checkdate renvoie false
    }
    else {
      $errors[$key] = 'Veuillez renseigner une date valide';
    }
  }
  // SI DATE EST VIDE
  else {
    $errors[$key] = 'Veuillez renseigner une date';
  }
  return $errors;
}

function validPostal($errors,$value,$key){
  if(!empty($value)){
    if(!is_numeric($value) || strlen($value) != 5) {
      $errors[$key] = 'Veuillez renseigner un code postal à 5 chiffres';
    }
  }
  else {
    $errors[$key] = 'Veuillez renseigner un code postal';
  }
  return $errors;
}


function validPostalNull($errors,$value,$key){
  if(strlen($value) == 0) {
    return $errors;
  }
  if(!is_numeric($value) || strlen($value) != 5) {
    $errors[$key] = 'Veuillez renseigner un code postal à 5 chiffres';
  }
  return $errors;
}





function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}


function formatageDate($valueDate)
{
  return date('d/m/Y à H:i',strtotime($valueDate));
}



function isLoggedUser()
{
  if(!empty($_SESSION['user'])) {
    if(!empty($_SESSION['user']['id']) && is_numeric($_SESSION['user']['id'])) {
      if(!empty($_SESSION['user']['pseudo'])) {
        if(!empty($_SESSION['user']['role'])) {
          if($_SESSION['user']['role'] == 'user') {
            if(!empty($_SESSION['user']['ip']) && $_SESSION['user']['ip'] == $_SERVER['REMOTE_ADDR']) {
              return true;
            }
          }
        }
      }
    }
  }
  return false;
}


function isLoggedAdmin()
{
  {
    if(!empty($_SESSION['user'])) {
      if(!empty($_SESSION['user']['id']) && is_numeric($_SESSION['user']['id'])) {
        if(!empty($_SESSION['user']['pseudo'])) {
          if(!empty($_SESSION['user']['role'])) {
            if($_SESSION['user']['role'] == 'admin') {
              if(!empty($_SESSION['user']['ip']) && $_SESSION['user']['ip'] == $_SERVER['REMOTE_ADDR']) {
                return true;
              }
            }
          }
        }
      }
    }
    return false;
  }

}
