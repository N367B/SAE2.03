<?php
session_start();
if (count($_SESSION) == 0) {
  header('Location: index.php');
}
?>

<!DOCTYPE html>

<html>
<head>
  <link rel="stylesheet" type="text/css" href="stylePlace.css">
</head>

<body>
<?php

//include "functions.php";
function getTime($id) {
  include 'requetes.php';
  $pdo = new PDO('sqlite:bdd.sqlite');
  $query = $requetes[6];
  $stmt = $pdo->prepare($query);
  $stmt->bindValue(1, $id, PDO::PARAM_INT);
  $stmt->execute();
  $resultD = $stmt->fetchAll();
  $pdo = null;
  return $resultD[0]['heure_dernier_pixel'];
}
?>

  <?php

  echo '<h3>' . "Vous êtes connecté en tant que " . $_SESSION['username'] . '</h3>';
  include 'requetes.php';
  $pdo = new PDO('sqlite:bdd.sqlite');
  $query = $requetes[3];
  $stmt = $pdo->prepare($query);
  $stmt->execute();
  $resultP = $stmt->fetchAll();
  $pdo = null;

  $pixels = [];

  for ($i = 0; $i < 16; $i++) {
    array_push($pixels, []);
    for ($j = 0; $j < 16; $j++) {
      array_push($pixels[$i], '');
    }
  }

  for ($i = 0; $i < count($resultP); $i++) {
    $pixels[$resultP[$i][0]][$resultP[$i][1]] = $resultP[$i][3];
  }
  ?>

  <script src="choix.js"></script>

  <br><br>

  <div class="container">

    <div class="Left">

      <script type="text/javascript">
        let colors = ["#FFFFFF", "#E4E4E4", "#888888", "#222222", "#FFA7D1", "#E50000", "#E59500", "#A06A42", "#E5D900", "#94E044", "#02BE01", "#00D3DD", "#0083C7", "#0000EA", "#CF6EE4", "#820080"];
        let pixels = <?php echo json_encode($pixels); ?>;
        document.write('<svg viewBox="0 0 17 17" xmlns="http://www.w3.org/2000/svg" class="SVGgrid" width="700px">');
        for (var i = 0; i < 16; i++) {
          for (var j = 0; j < 16; j++) {
            document.write(`<rect x="${j}" y="${i}" width="1" height="1" fill="${pixels[i][j]}" id="${j}-${i}" onclick="recup(${j},${i})"/>`);          }
        }
        evenements();
        document.write('</svg>');
      </script>

    </div>

    <br><br>

    <div class="Right">
      <form id="formulaire" name="formulaire" method='post'>
        <input type="text" id="x" name="x" placeholder="Colonne">
        <input type="text" id="y" name="y" placeholder="Ligne">
        <input type="color" id="head" name="head" value= <?php echo $_SESSION['color'];?>>
        <br><br>
        <input type="submit" name="btnSubmit" value="Valider" class="button">
      </form>

      <?php


if (isset($_POST["x"])) {
      $_SESSION['color'] = $_POST['head'];
  if (microtime(true) - getTime($_SESSION['session']) > 60 or $_SESSION['session'] == 1) {
      $UCouleur = $_POST["head"];
      $Ux = $_POST["y"];
      $Uy = $_POST["x"];
      $Uid = $_SESSION['session'];
      include 'requetes.php';
      $pdo = new PDO('sqlite:bdd.sqlite');
      $query = $requetes[4];
      $stmt = $pdo->prepare($query);
      $stmt->bindValue(1, $UCouleur, PDO::PARAM_STR);
      $stmt->bindValue(2, $Uid, PDO::PARAM_STR);
      $stmt->bindValue(3, $Ux, PDO::PARAM_STR);
      $stmt->bindValue(4, $Uy, PDO::PARAM_STR);
      $stmt->execute();
      $pdo = null;

      $pdo = new PDO('sqlite:bdd.sqlite');
      $query = $requetes[5];
      $stmt = $pdo->prepare($query);
      $stmt->bindValue(1, microtime(true), PDO::PARAM_STR);
      $stmt->bindValue(2, $Uid, PDO::PARAM_STR);
      $stmt->execute();
      $pdo = null;

      header("Refresh:0");
    } else {
      echo "Attendez " . round(60 - (microtime(true) - getTime($_SESSION['session']))) . " secondes";
    }
  }
       ?>

<br><br>

      <form method='post'>
        <input type="submit" name="deco" value="Déconnexion" class="button">
      </form>

      <?php

      if (isset($_POST['deco'])) {
        if ($_POST['deco'] == "Déconnexion") {
          #unset($_SESSION);
          session_destroy();
          header('Location: index.php');
      }
    }
      ?>
    </div>
  </div>
</body>

</html>
