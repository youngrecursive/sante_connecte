<?php
session_start();
require('../inc/pdo.php');
require('../inc/function.php');
if(!isLoggedAdmin()) {
 header('Location: ../index.php');
 exit(); }


// TRAITEMENT
$errors = array();
if(!empty($_GET['id']) && is_numeric($_GET['id'])) {
  $id = $_GET['id'];

  // Verification de l'existence de l'utilisateur dans la BDD
  $sql = "SELECT * FROM nf_users WHERE id = :id";
  $query = $pdo->prepare($sql);
  $query->bindValue(':id',$id,PDO::PARAM_INT);
  $query->execute();
  $user = $query->fetch();

  if(!empty($user)) { // user existe
    if(!empty($_POST['submitted'])) { // formulaire soumis

      // FAille XSS
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

      // REQUÊTE DE L'UPDATE

      if(count($errors) == 0) {
        $sql = "UPDATE nf_users
                SET nom = :nom,prenom=:prenom,civilitee=:civilitee,date_naissance=:date_naissance,adresse1=:adresse1,adresse2=:adresse2,ville=:ville,codepostal=:codepostal,role=:role,email=:email,updated_at= NOW()
                WHERE id = :id";
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
        $query->bindValue(':id',$id,PDO::PARAM_INT);
        $query->execute();

        // redirection
        header('Location: tables.php');
        die();
      }
    }
  } else {
    header('Location: 404.php');
    die();
  }
} else {
  header('Location: 404.php');
  die();
}

include('inc/header.php'); ?>
<h2>Editer</h2>

<form class="formulaire" action="" method="post">
  <!-- NOM -->
  <div class="form_nom form_ensemble">
    <label for="nom">Nom</label>
    <input id="nom" type="text" name="nom" value="<?php if(!empty($_POST['nom'])){echo $_POST['nom'];} else { echo $user['nom']; } ?>">
    <span class="error"><?php if(!empty($errors['nom'])){echo $errors['nom'];} ?></span>
  </div>
  <!-- PRENOM -->
  <div class="form_prenom form_ensemble">
    <label for="prenom">Prenom</label>
    <input id="prenom" type="text" name="prenom" value="<?php if(!empty($_POST['prenom'])){echo $_POST['prenom'];} ?>">
    <span class="error"><?php if(!empty($errors['prenom'])){echo $errors['prenom'];} ?></span>
  </div>
  <!-- CIVILITEE -->
  <div class="form_civilitee form_ensemble">
    <label for="civilitee">Civilitée</label>
    <input id="civilitee" type="text" name="civilitee" value="<?php if(!empty($_POST['civilitee'])){echo $_POST['civilitee'];} else {echo $user['civilitee'];} ?>">
    <span class="error"><?php if(!empty($errors['civilitee'])){echo $errors['civilitee'];} ?></span>
  </div>
  <!-- DATE DE NAISSANCE -->
  <div class="form_civilitee form_ensemble">
    <label for="date_naissance">Date de naissance</label>
    <input id="date_naissance" type="text" name="date_naissance" value="<?php if(!empty($_POST['date_naissance'])){echo $_POST['date_naissance'];} else {echo $user['date_naissance'];} ?>">
    <span class="error"><?php if(!empty($errors['date_naissance'])){echo $errors['date_naissance'];} ?></span>
  </div>
  <!-- ADRESSE PRINCIPALE -->
  <div class="form_adresse1 form_ensemble">
    <label for="adresse1">Adresse Principale</label>
    <input id="adresse1" type="text" name="adresse1" value="<?php if(!empty($_POST['adresse1'])){echo $_POST['adresse1'];} else {echo $user['adresse1'];} ?>">
    <span class="error"><?php if(!empty($errors['adresse1'])){echo $errors['adresse1'];} ?></span>
  </div>
  <!-- ADRESSE SECONDAIRE -->
  <div class="form_adresse2 form_ensemble">
    <label for="adresse2">Adresse Secondaire</label>
    <input id="adresse2" type="text" name="adresse2" value="<?php if(!empty($_POST['adresse2'])){echo $_POST['adresse2'];} else {echo $user['adresse2'];} ?>">
    <span class="error"><?php if(!empty($errors['adresse2'])){echo $errors['adresse2'];} ?></span>
  </div>
  <!-- VILLE -->
  <div class="form_ville form_ensemble">
    <label for="ville">Ville</label>
    <input id="ville" type="text" name="ville" value="<?php if(!empty($_POST['ville'])){echo $_POST['ville'];} else {echo $user['ville'];} ?>">
    <span class="error"><?php if(!empty($errors['ville'])){echo $errors['ville'];} ?></span>
  </div>
  <!-- CODE POSTAL -->
  <div class="form_codepostal form_ensemble">
    <label for="codepostal">Code Postal</label>
    <input id="codepostal" type="text" name="codepostal" value="<?php if(!empty($_POST['codepostal'])){echo $_POST['codepostal'];} else {echo $user['codepostal'];} ?>">
    <span class="error"><?php if(!empty($errors['codepostal'])){echo $errors['codepostal'];} ?></span>
  </div>
  <!-- ROLE -->
  <div class="form_role form_ensemble">
    <label for="role">Role</label>
    <input id="role" type="text" name="role" value="<?php if(!empty($_POST['role'])){echo $_POST['role'];} else {echo $user['role'];} ?>">
    <span class="error"><?php if(!empty($errors['role'])){echo $errors['role'];} ?></span>
  </div>
  <!-- EMAIL -->
  <div class="form_email form_ensemble">
    <label for="email">Email</label>
    <input id="email" type="email" name="email" value="<?php if(!empty($_POST['email'])){echo $_POST['email'];} else {echo $user['email'];} ?>">
    <span class="error"><?php if(!empty($errors['email'])){echo $errors['email'];} ?></span>
  </div>
  <!-- SUBMIT -->
  <div class="form_submit form_ensemble">
    <input type="submit" name="submitted" value="Modifier">
  </div>
</form>



<?php include('inc/footer.php');
