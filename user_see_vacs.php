<?php
// VISIBLE SEULEMENT POUR USERS CONNECTES ET VALIDES
session_start();
include('inc/pdo.php');
include('inc/function.php');
$errors = array();

$successvac = false;
$success = false;


if(isLoggedUser() || isLoggedAdmin()){
  if(!empty($_GET['id']) && is_numeric($_GET['id'])) {

    // On vérifie que id concorde avec l'user connecté
    if($_SESSION['user']['id'] == $_GET['id']) { $id = $_GET['id']; }
    else { header('Location: 404.php'); exit(); }
    $pseudo = $_SESSION['user']['pseudo'];

    // On récupère l'user en question
    $sql = "SELECT * FROM nf_users WHERE id = '$id' AND email = '$pseudo'";
    $query = $pdo->prepare($sql);
    $query->execute();
    $user = $query->fetch();

    // On récupère tous les vaccins
    $sql = "SELECT * FROM vaccins";
    $query = $pdo->prepare($sql);
    $query->execute();
    $vaccins = $query->fetchAll();

    // On vérifie si il y a des vaccins en BDD sait-on jamais...
    if(!empty($vaccins)){
      $sql = "SELECT * FROM vaccins INNER JOIN vaccins_user ON vaccins.id = vaccins_user.vaccin_id";
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
          $success = true;

          $sql = "INSERT INTO vaccins_user (user_id,vaccin_id,date_vaccin) VALUES ('$user_id','$vaccin',:date_vaccin)";

          // INSERT
          $query = $pdo->prepare($sql);
          $query->bindValue(':date_vaccin',$date_vaccin,PDO::PARAM_STR);
          $query->execute();

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
      <option value="">Liste des vaccins</option>
      <?php foreach ($vaccins as $vaccin): ?>
        <option value="<?= $vaccin['id'] ?>"><?= $vaccin['nomvaccin'] ?></option>
      <?php endforeach; ?>
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
  if(!empty($success)){ ?>
    <span class="green">Vous venez d'ajouter un vaccin !</span>
  <?php } ?>
</form>
<div class="form tableau">

<?php  if(!empty($successvac)){ ?>
    <h1>Ma liste de vaccins</h1>
    <table class="content-table">
      <thead>
        <tr>
          <th>Vaccin</th>
          <th>Fait le</th>
          <th>Supprimer</th>
        </tr>
      </thead>
    <tbody>
    <?php $user_id = $user['id'];
      foreach ($madevaccins as $madevaccin): ?>
        <tr>
          <td><?= $madevaccin['nomvaccin'] ?></td>
          <td><?= formatageShortDate($madevaccin['date_vaccin']) ?></td>
          <td><a href="user_delete_vac.php?id=<?= $user_id ?>/<?= $madevaccin['vaccin_id'] ?>">Retirer ce vaccin</a></td>
        </tr>
    <?php endforeach; ?>
  <?php } else { ?>
    <p>Vous n'avez pas encore renseigné de vaccins...</p>
  <?php } ?>
</tbody>
</table>
</div>





</section>
<?php
include('inc/footer.php');
