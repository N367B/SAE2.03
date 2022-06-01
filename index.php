<!DOCTYPE html>
<html>

<head>
  <link rel="stylesheet" type="text/css" href="styleIndex.css">

</head>

<body>

  <div class="container">
    <div class="tl"></div>
    <div class="tm"></div>
    <div class="tr"></div>
    <div class="ml"></div>
    <div class="mm">
      <form method="post">
        <input type="text" name="username" placeholder="nom">
        <input type="password" name="password" placeholder="mot de passe">
        <br><br>
        <input type="submit" name="submit" value="Connexion" class="button">
        <input type="submit" name="submit" value="Inscription" class="button">
    </div>
    <div class="mr"></div>
    <div class="bl"></div>
    <div class="bm"></div>
    <div class="br"></div>
  </div>
</body>

</html>

<?php

/*----------------------------*/
if (isset($_POST['submit'])) {
  if ($_POST['submit'] == 'Connexion') {
    include 'requetes.php';
    $name = $_POST['username'];
    $pdo = new PDO('sqlite:bdd.sqlite');
    $query = $requetes[0];
    $stmt = $pdo->prepare($query);
    $stmt->bindValue(1, $_POST['username'], PDO::PARAM_STR);
    $stmt->bindValue(2, md5($_POST['password']), PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetchAll();
    $pdo = null;
    if (isset($result[0][1])) {
      session_start();
      $_SESSION["newsession"] = $result[0]['id_membre'];
      $_SESSION['username'] = $_POST['username'];
      header('Location: place.php');
    } else {
      echo "<h3>Identifiant ou mot de passe incorrecte<h3>";
    }
  }

  if ($_POST['submit'] == 'Inscription') {
    $name = $_POST['username'];
    if (checkName($name)) {
      #if ()
      include 'requetes.php';
      $pdo = new PDO('sqlite:bdd.sqlite');
      $query = $requetes[1];
      $stmt = $pdo->prepare($query);
      $stmt->bindValue(1, $_POST['username'], PDO::PARAM_STR);
      $stmt->bindValue(2, md5($_POST['password']), PDO::PARAM_STR);
      $stmt->bindValue(3, date('Y-m-d H:i:s'), PDO::PARAM_STR);
      $stmt->execute();
      $pdo = null;
      echo '<h3>Utilisateur ' . $_POST['username'] . ' créé</h3>';
    } else {
      echo "<h3>Mauvais identifiant</h3>";
    }
  }
} else {}

function checkName($name){
  if ($name == str_replace(' ', '', $name)){
    include 'requetes.php';
    $pdo = new PDO('sqlite:bdd.sqlite');
    $query = $requetes[2];
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $resultA = $stmt->fetchAll();
    $pdo = null;
    foreach ($resultA as $A) {
      if ($A[1] == $name) {
        return False;
      }
    }
    return True;
  } else {
    return False;
  }
}



?>
