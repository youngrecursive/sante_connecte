<?php session_start(); ?>
<?php require('../inc/function.php'); ?>
<?php require('../inc/pdo.php'); ?>

<?php if(!isLoggedAdmin()) {
  header('Location: ../index.php');
  exit(); } ?>

<?php include('inc/header.php');


// EDIT vaccins_user

if(isset($_POST['ok'])) {

   $id=$_POST['id'];
   $user_id=$_POST['user_id'];
   $vaccin_id=$_POST['vaccin_id'];
   $date_vaccin=$_POST['date_vaccin'];

   $sql="UPDATE vaccins_user SET user_id='$user_id', vaccin_id='$vaccin_id', date_vaccin='$date_vaccin' WHERE id= $id";
   $query = $pdo->prepare($sql);
   $query->execute();
   if(!$query) {
    die('Erreur!');
   }
    else {
     echo "<div class='alert alert-success'><h1>Requête validée !</h1><p>La mise a jour a bien été effectuée !</p>";
   }
}
if(isset($_GET['m'])) {

    $id = $_GET['m'];
    $sql = "SELECT * FROM vaccins_user WHERE id=".$id."";
    $query = $pdo->prepare($sql);
    $query->execute();
    $data = $query->fetchAll(PDO::FETCH_ASSOC);

}
?>
    <form action="edit.php" method="POST">
      <input name="user_id" type="text" value=<?php echo($data[0]['user_id']) ?> >
      <input name="vaccin_id" type="text" value=<?php echo($data[0]['vaccin_id']) ?> >
      <input name="date_vaccin" type="text" value=<?php echo($data[0]['date_vaccin']) ?> >
      <a href="tables2.php">Retour</a>
      <input type="submit" name="ok">
    </form>

    <!-- EDIT nf_users -->
    <?php
      if(isset($_POST['ok'])) {
       $id=$_POST['id'];
       $name=$_POST['name'];
       $prenom=$_POST['prenom'];
       $civilitee=$_POST['civilitee'];
       $birthday=$_POST['date_naissance'];
       $adresse1=$_POST['adresse1'];
       $adresse2=$_POST['adresse2'];
       $ville=$_POST['ville'];
       $codepostal=$_POST['codepostal'];
       $role=$_POST['role'];
       $email=$_POST['email'];

       $sql="UPDATE nf_users SET id='$id', name='$name', prenom='$prenom', civilitee='$civilitee', date_naissance='$birthday', adresse1='$adresse1', adresse2='$adresse2', ville='$ville', codepostal='$codepostal', role='$role', email= '$email' WHERE id= $id";
       $query = $pdo->prepare($sql);
       $query->execute();
       if(!$query) {
        die('Erreur!');
       }
        else {
         echo "<div class='alert alert-success'><h1>Requête validée !</h1><p>La mise a jour a bien été effectuée !</p>";
       }
    }

      if(isset($_GET['m'])) {
        $id = $_GET['m'];
        $sql = "SELECT * FROM nf_users WHERE id=".$id."";
        $query = $pdo->prepare($sql);
        $query->execute();
        $data = $query->fetchAll(PDO::FETCH_ASSOC);
        }
        ?>

        <form action="edit.php" method="POST">
          <input name="name" type="text" value=<?php echo($data[0]['name']) ?> >
          <input name="prenom" type="text" value=<?php echo($data[0]['prenom']) ?> >
          <input name="civilitee" type="text" value=<?php echo($data[0]['civilitee']) ?> >
          <input name="date_naissance" type="text" value=<?php echo($data[0]['date_naissance']) ?> >
          <input name="adresse1" type="text" value=<?php echo($data[0]['adresse1']) ?> >
          <input name="adresse2" type="text" value=<?php echo($data[0]['adresse2']) ?> >
          <input name="ville" type="text" value=<?php echo($data[0]['ville']) ?> >
          <input name="codepostal" type="text" value=<?php echo($data[0]['codepostal']) ?> >
          <input name="role" type="text" value=<?php echo($data[0]['role']) ?> >
          <input name="email" type="text" value=<?php echo($data[0]['email']) ?> >
          <a href="tables.php">Retour</a>
          <input type="submit" name="ok">
        </form>


<?php include('inc/footer.php');
