<?php

session_start();
require('../inc/pdo.php');
require('../inc/function.php');
if(!isLoggedAdmin()) {
 header('Location: ../index.php');
 exit(); }


// TRAITEMENT
$errors = array();
if(!empty($_POST['submitted'])) {
  // Faille Xss
  $nom   = trim(strip_tags($_POST['nom']));
  $prenom = trim(strip_tags($_POST['prenom']));
  $civilitee  = trim(strip_tags($_POST['civilitee']));
  $date_naissance  = trim(strip_tags($_POST['date_naissance']));
  $adresse1  = trim(strip_tags($_POST['adresse1']));
  $adresse2  = trim(strip_tags($_POST['adresse2']));
  $ville  = trim(strip_tags($_POST['ville']));
  $codepostal  = trim(strip_tags($_POST['codepostal']));
  $role  = trim(strip_tags($_POST['role']));
  $email  = trim(strip_tags($_POST['email']));

  // VALIDATION DES CHAMPS
  $errors = validText($errors,$nom,'nom',2,120);
  $errors = validText($errors,$prenom,'prenom',2,120);
  $errors = validText($errors,$civilitee,'civilitee',2,30);
  $errors = validText($errors,$date_naissance,'date_naissance',2,50);
  $errors = validText($errors,$adresse1,'adresse1',2,250);
  $errors = validText($errors,$adresse2,'adresse2',2,250);
  $errors = validText($errors,$ville,'ville',2,120);
  $errors = validText($errors,$codepostal,'codepostal',5,5);
  $errors = validText($errors,$role,'role',2,30);
  $errors = validText($errors,$email,'email',2,150);

  if(count($errors) == 0) {
      $sql = "INSERT INTO nf_users (nom,    prenom,civilitee,date_naissance,adresse1,adresse2,ville,codepostal,role,email,created_at)
      VALUES(:nom,:prenom,:civilitee,:date_naissance,:adresse1,:adresse2,:ville,:codepostal,:role,:email,NOW())";
      $query = $pdo->prepare($sql);
      $query->bindValue(':nom',$nom,PDO::PARAM_STR);
      $query->bindValue(':prenom',$prenom,PDO::PARAM_STR);
      $query->bindValue(':civilitee',$civilitee,PDO::PARAM_STR);
      $query->bindValue(':date_naissance',$date_naissance,PDO::PARAM_INT);
      $query->bindValue(':adresse1',$adresse1,PDO::PARAM_STR);
      $query->bindValue(':adresse2',$adresse2,PDO::PARAM_STR);
      $query->bindValue(':ville',$ville,PDO::PARAM_STR);
      $query->bindValue(':codepostal',$codepostal,PDO::PARAM_INT);
      $query->bindValue(':role',$role,PDO::PARAM_STR);
      $query->bindValue(':email',$email,PDO::PARAM_STR);
      $query->execute();
      // redirection
      if($sql == true){
        echo '<div class="alert alert-success">Votre requête a bien été effectuée !<br> Redirection en cours...</br></div>';
        header("Refresh: 3; URL=tables.php");
      }
  }
}

include('inc/header.php'); ?>

<div class="container-fluid">
  
<h1 class="text-dark">Nouvel utilisateur:</h1><br>

<form class="formulaire" action="" method="POST">

  <!-- NOM -->
  <div class="control-form">
    <label class="form-check-label text-dark" for="nom">Nom</label>
    <input class="form-control w-50" id="nom" type="text" name="nom" value="<?php if(!empty($_POST['nom'])){echo $_POST['nom'];} ?>">
    <span class="error_form"><?php if(!empty($errors['nom'])){echo $errors['nom'];} ?></span>
  </div>

  <!-- PRENOM -->
  <div class="control-form">
    <label class="form-check-label text-dark" for="prenom">Prenom</label>
    <input class="form-control w-50" id="prenom" type="text" name="prenom" value="<?php if(!empty($_POST['prenom'])){echo $_POST['prenom'];} ?>">
    <span class="error_form"><?php if(!empty($errors['prenom'])){echo $errors['prenom'];} ?></span>
  </div>

  <!-- CIVILITEE -->
  <div class="control-form">
    <label class="form-check-label text-dark" for="civilitee">Civilitée</label>
    <input class="form-control w-50" id="civilitee" type="text" name="civilitee" value="<?php if(!empty($_POST['civilitee'])){echo $_POST['civilitee'];} ?>">
    <span class="error_form"><?php if(!empty($errors['civilitee'])){echo $errors['civilitee'];} ?></span>
  </div>

  <!-- DATE DE NAISSANCE -->
  <div class="control-form">
    <label class="form-check-label text-dark" for="date_naissance">Date de naissance</label>
    <input class="form-control w-50" id="date_naissance" type="text" name="date_naissance" value="<?php if(!empty($_POST['date_naissance'])){echo $_POST['date_naissance'];} ?>">
    <span class="error_form"><?php if(!empty($errors['date_naissance'])){echo $errors['date_naissance'];} ?></span>
  </div>

  <!-- ADRESSE PRINCIPALE -->
  <div class="control-form">
    <label class="form-check-label text-dark" for="adresse1">Adresse Principale</label>
    <input class="form-control w-50" id="adresse1" type="text" name="adresse1" value="<?php if(!empty($_POST['adresse1'])){echo $_POST['adresse1'];} ?>">
    <span class="error_form"><?php if(!empty($errors['adresse1'])){echo $errors['adresse1'];} ?></span>
  </div>

  <!-- ADRESSE SECONDAIRE -->
  <div class="control-form">
    <label class="form-check-label text-dark" for="adresse2">Adresse Secondaire</label>
    <input class="form-control w-50" id="adresse2" type="text" name="adresse2" value="<?php if(!empty($_POST['adresse2'])){echo $_POST['adresse2'];} ?>">
    <span class="error_form"><?php if(!empty($errors['adresse2'])){echo $errors['adresse2'];} ?></span>
  </div>

  <!-- VILLE -->
  <div class="control-form">
    <label class="form-check-label text-dark" for="ville">Ville</label>
    <input class="form-control w-50" id="ville" type="text" name="ville" value="<?php if(!empty($_POST['ville'])){echo $_POST['ville'];} ?>">
    <span class="error_form"><?php if(!empty($errors['ville'])){echo $errors['ville'];} ?></span>
  </div>

  <!-- CODE POSTAL -->
  <div class="control-form">
    <label class="form-check-label text-dark" for="codepostal">Code Postal</label>
    <input class="form-control w-50" id="codepostal" type="text" name="codepostal" value="<?php if(!empty($_POST['codepostal'])){echo $_POST['codepostal'];} ?>">
    <span class="error_form"><?php if(!empty($errors['codepostal'])){echo $errors['codepostal'];} ?></span>
  </div>

  <!-- ROLE -->
  <div class="control-form">
    <label class="form-check-label text-dark" for="role">Role</label>
    <input class="form-control w-50" id="role" type="text" name="role" value="<?php if(!empty($_POST['role'])){echo $_POST['role'];} ?>">
    <span class="error_form"><?php if(!empty($errors['role'])){echo $errors['role'];} ?></span>
  </div>

  <!-- EMAIL -->
  <div class="control-form">
    <label class="form-check-label text-dark" for="email">Email</label>
    <input class="form-control w-50" id="email" type="email" name="email" value="<?php if(!empty($_POST['email'])){echo $_POST['email'];} ?>">
    <span class="error_form"><?php if(!empty($errors['email'])){echo $errors['email'];} ?></span>
  </div>
  <!-- SUBMIT -->

    <div class="my-2"></div>
    <div class="btn btn-success btn-icon-split">
    <span class="icon text-white-50">
        <i class="fas fa-check"></i>
    </span>
    <input class="btn btn-success btn-icon-split" type="submit" name="submitted" value="  Ajouter l'utilisateur  ">
    </div>
    <!-- ANNULATION -->
    <td><a href="tables.php" class="btn btn-secondary btn-icon-split">
      <span class="icon text-white-50">
          <i class="fas fa-arrow-right"></i>
      </span>
      <span class="text"><?php echo 'Annuler' ?></span>
      </a></td>
</form>



<?php include('inc/footer.php');
