<?php
// VISIBLE SEULEMENT POUR USERS CONNECTES ET VALIDES
session_start();
include('inc/pdo.php');
include('inc/function.php');
$errors = array();

$successvac = false;
$xplode = explode('/', $_GET['id']);
// Même si il n'y a pas de slash xplode[0] fonctionne quand même
$getid = $xplode[0];
$souschaine = '/';
if (strpos($_GET['id'], $souschaine) !== FALSE) {
  if(!empty($xplode[1])){
    if($xplode[1] == 'success'){
      $flash = 'Vous venez d\'ajouter un vaccin !';
    }
    elseif($xplode[1] == 'delete'){
      $flash = 'Vous venez de retirer un vaccin !';
    }
    elseif($xplode[1] == 'update'){
      $flash = 'Vaccin mis à jour !';
    }
    else {
      header('Location: 404.php');
      exit();
    }
  }
}



if(isLoggedUser() || isLoggedAdmin()){
  //if(!empty($_GET['id']) && is_numeric($_GET['id'])) {
  if(!empty($getid) && is_numeric($getid)) {

    // On vérifie que id concorde avec l'user connecté
    if($_SESSION['user']['id'] == $getid) { $id = $getid; }
    else { header('Location: 404.php'); exit(); }
    $pseudo = $_SESSION['user']['pseudo'];

    // On récupère l'user en question
    $sql = "SELECT * FROM nf_users WHERE id = '$id' AND email = '$pseudo'";
    $query = $pdo->prepare($sql);
    $query->execute();
    $user = $query->fetch();

    // On récupère tous les vaccins
    //$sql = "SELECT * FROM vaccins";
    $sql = "SELECT * FROM vaccins";
    $query = $pdo->prepare($sql);
    $query->execute();
    $vaccins = $query->fetchAll();

    // On vérifie si il y a des vaccins en BDD sait-on jamais...
    if(!empty($vaccins)){

      $sql = "SELECT * FROM vaccins INNER JOIN vaccins_user ON vaccins.id = vaccins_user.vaccin_id WHERE user_id = '$id'";
      $query = $pdo->prepare($sql);
      $query->execute();
      $madevaccins = $query->fetchAll();

      if(!empty($madevaccins)){

        // IF TRUE ON AFFICHE LES VACCINS DE LA PERSONNE
        $successvac = true;
      }
    }

    // Si user existe
    if(!empty($user)){
      if(!empty($_POST['submitted'])){
        $user_id = $user['id'];
        $vaccin = cleanXss($_POST['vaccin']);
        $date_vaccin = cleanXss($_POST['date_vaccin']);
        $errors = emptyError($errors,$vaccin,'vaccin');
        $errors = validDate($errors,$date_vaccin,'date_vaccin');


        if(count($errors) == 0){
          $sql = "SELECT id FROM vaccins_user WHERE user_id = '$user_id' AND vaccin_id = '$vaccin'";
          $query = $pdo->prepare($sql);
          $query->execute();
          $UserVaccinExist = $query->fetch();

          if(!empty($UserVaccinExist)){
            $errors['vaccin'] = 'Vous avez déjà renseigné ce vaccin';
          }

          if(count($errors) == 0){

            $sql = "INSERT INTO vaccins_user (user_id,vaccin_id,date_vaccin) VALUES ('$user_id','$vaccin',:date_vaccin)";

            // INSERT
            $query = $pdo->prepare($sql);
            $query->bindValue(':date_vaccin',$date_vaccin,PDO::PARAM_STR);
            $query->execute();

            header('Location: user_see_vacs.php?id='.$_SESSION['user']['id'].'/success');
            exit();
          }


        }

      }
    }

    // User n'existe pas
    else {
      header('Location: 404.php');
      exit();
    }

  }

  // SI L'URL NE CONTIENT PAS D'ID OU QU'IL N'EST PAS NUMERIQUE
  else {
    header('Location: 404.php');
    exit();
  }
}

// SI USER N'EST PAS CONNECTE
else {
  header('Location: 404.php');
  exit();
}










include('inc/header.php'); ?>
<section id="section-userseevac" class="format">

<form class="form" action="" method="post">
  <h1>Ajouter un vaccin</h1>

  <!-- Choix du vaccin -->
  <div class="gg">
    <select class="" name="vaccin">
      <option style="display: none;" value="">Liste des vaccins non effectués</option>
      <?php foreach ($vaccins as $vaccin) {
        $made = false;
        foreach($madevaccins as $madevaccin) {
           ?>
            <?php
             if (in_array($madevaccin['nomvaccin'], $vaccin)) {
              $made = true;
               } ?>
          <?php
        } ?>
        <option <?php if(empty($made)) { ?> style="display: block;" <?php } else { ?> style="display: none;" <?php } ?> value="<?= $vaccin['id'] ?>"><?= $vaccin['nomvaccin'] ?></option>
      <?php } ?>
    </select>
    <span class="error"><?php if(!empty($errors['vaccin'])) { echo $errors['vaccin']; } ?></span>

    <!-- Date à laquelle la personne est vaccinée -->
    <div class="date">
      <label id="" for="date_vaccin">Date du vaccin : </label>
      <input type="date" name="date_vaccin" max="9999-12-31" value="<?php if(!empty($_POST['date_vaccin'])) { echo $_POST['date_vaccin']; } ?>">
      <span class="error"><?php if(!empty($errors['date_vaccin'])) { echo $errors['date_vaccin']; } ?></span>
    </div>

  <!-- Submit -->
</div>
  <input class="submit" type="submit" name="submitted" value="Envoyer">
<?php

  if(!empty($flash)){ ?>
    <span class="green"><?= $flash ?></span>
   <?php } ?>

</form>

<?php  if(!empty($successvac)){ ?>
  <div class="form tableau">
    <h1>Ma liste de vaccins</h1>
    <table class="content-table">
      <thead>
        <tr>
          <th>Vaccin</th>
          <th>Fait le</th>
          <th>Expire le</th>
          <th>Actualiser</th>
          <th>Supprimer</th>
        </tr>
      </thead>
    <tbody>

    <?php
      $user_id = $user['id'];
      $now = new DateTime("now");
      foreach ($madevaccins as $madevaccin): ?>
        <tr>
          <td><?= $madevaccin['nomvaccin'] ?></td>
          <td><?= formatageShortDate($madevaccin['date_vaccin']) ?></td>
          <?php   $perime = New DateTime($madevaccin['date_vaccin']);
                  if(!empty($madevaccin['peremption'])){
                    $perime->add(new DateInterval('P'.$madevaccin['peremption'].'Y'));
                  }
                  else {
                    $perime->add(new DateInterval('P10Y'));
                  }
          ?>
          <td <?php if($perime < $now) {echo 'style="color:#FF0000"';} ?>><?= $perime->format('d/m/Y') ?> </td>
          <td><?php if($perime < $now){ ?> <a href="user_update_vac.php?id=<?= $user_id ?>/<?= $madevaccin['vaccin_id'] ?>">Mettre à jour</a> <?php } else { ?> <p style="color:#008000">Vaccin à jour</p> <?php } ?></td>
          <td><a href="user_delete_vac.php?id=<?= $user_id ?>/<?= $madevaccin['vaccin_id'] ?>">Retirer ce vaccin</a></td>

        </tr>

    <?php endforeach; ?>
  </tbody>
</table>
</div>
  <?php } else { ?>
    <div class="form tableau">
      <h2>Vous n'avez pas encore renseigné de vaccins...</h2>
    </div>
  <?php } ?>

</section>


<?php
include('inc/footer.php');
