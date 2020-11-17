<?php
session_start();
require('../inc/function.php');
require('../inc/pdo.php');

if(!isLoggedAdmin()) {
  header('Location: ../index.php');
  exit(); }

//valiation du formulaire
$errors = array();
if (!empty($_POST['submitted'])) {
  // faille xss
  $nomvaccin   = cleanXss($_POST['nomvaccin']);
  $description = cleanXss($_POST['description']);

  //validation nomvaccin  (min 2,max 50)
  $errors = validText($errors,$nomvaccin,'nomvaccin',2,50);
  //validation description (min 2 , max 500)
  $errors = validText($errors,$description,'description',2,500);

  //insertion dans la base de donnée, s'il n'y a pas d'erreur dans le formulaire
  if (count($errors) == 0) {
    $success = true;
    $nombrerappel = $_POST['nombrerappel'];
    $intervallerappel = $_POST ['intervallerappel'];
    $sql = "INSERT INTO vaccins (nomvaccin,description,nombrerappel,intervallerappel)
            VALUES (:nomvaccin,:description, $nombrerappel,$intervallerappel)";
    $query = $pdo->prepare($sql);
    $query->bindValue(':nomvaccin',$nomvaccin,PDO::PARAM_STR);
    $query->bindValue(':description',$description,PDO::PARAM_STR);
    $query->execute();

      // die('You Died');
  }
}

include('inc/header.php'); ?>

  <div class="container-fluid">
    <!-- Titre de page -->

    <!-- début section tableau -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Liste des vaccins:</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        </td>
                      </tr>
                    <thead>
                        <tr>
                            <th>Nom du vaccin</th>
                            <th>Description</th>
                            <th>Nombre de rappel</th>
                            <th>Intervalle de rappel (en mois)</th>
                            <th>Détails</th>
                            <th>Modifier</th>
                            <th>Supprimer</th>
                        </tr>
                    </thead>
                    <tbody>
                      <?php
                      // $errors = array();

                      $sql = "SELECT * FROM vaccins";
                      $query = $pdo->prepare($sql);
                      $query->execute();
                      $data = $query->fetchAll();
                      for ($i=0; $i < count($data) ; $i++) { ?>
                        <tr>
                          <td><?php echo($data[$i]['nomvaccin']); ?></td>
                          <td><?php echo($data[$i]['description']); ?></td>
                          <td><?php echo($data[$i]['nombrerappel']); ?></td>
                          <td><?php echo($data[$i]['intervallerappel']); ?></td>
                          <td><a href="details_vaccine.php?id=<?php echo($data[$i]['id']); ?>"><?php echo 'Détails' ?></a></td>
                          <td><a href="edit_vaccine.php?id=<?php echo($data[$i]['id']); ?>"><?php echo 'Modifier' ?></a></td>
                          <td><a href="delete_vaccine.php?id=<?php echo($data[$i]['id']); ?>"><?php echo 'Supprimer' ?></a></td>
                        </tr>
                        <?php
                      }
                      ?>
                    </table>
                </tbody>
            </div>
        </div>
    </div>

    <!-- début section vaccin -->
    <h1 class="h3 mb-2 text-gray-800">Ajouter un nouveau vaccin</h1>
    <!-- début formulaire nouveau vaccin -->
        <form class=""  method="POST">

<!-- Ajout d'un vaccin, et affichage des erreurs d'entrées. -->
          <div class="form_group">
          <label for="vaccin">Nom du vaccin</label>
            <input type="text" name="nomvaccin" id="nomvaccin" value="<?php if(!empty($_POST['nomvaccin'])) { echo $_POST['nomvaccin']; } ?>">
            <span class="error_form"><?php if(!empty($errors['nomvaccin'])) { echo $errors['nomvaccin']; } ?></span>
          </div>

<!-- ajout d'une description, et affichage des erreurs d'entrées -->
          <div class="form_group">
            <label for="description">Description</label>
            <textarea name="description" id="description" rows="8" cols="80" value"<?php if(!empty($_POST['description'])) { echo $_POST['description']; } ?>"></textarea>
            <span class="error_form"><?php if(!empty($errors['description'])) { echo $errors['description']; } ?></span>
          </div>

<!-- ajout des rappels, et affichagedes erreurs d'entrées -->
          <div class="form_group">
            <label for="nombrerappel">Nombre de rappel</label>
            <input type="number" name="nombrerappel" id="nombrerappel" value="0" min ="0" >
            <span class="error_form"></span>
          </div>

<!-- ajout de l'intervalle de rappel  et affichag des erreurs d'entrées-->
          <div class="form_group">
            <label for="intervallerappel">intervalle de rappel (mois)</label>
            <input type="number" name="intervallerappel" value="0" min ="0  ">
            <span class="error_form"></span>
          </div>

          <input type="submit" name="submitted" value="Ajouter un vaccin">
        </form>

  </div>

<?php include('inc/footer.php'); ?>
