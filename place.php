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
  echo '<h3>' . "Vous êtes connecté en tant que " . $_SESSION['username'] . '</h3>';
  include 'requetes.php';
  $pdo = new PDO('sqlite:bdd.sqlite');
  $query = $requetes[3];
  $stmt = $pdo->prepare($query);
  $stmt->execute();
  $resultA = $stmt->fetchAll();
  $pdo = null;
  foreach ($resultA as $A) {
    var_dump($A);
  }


  ?>
  <br><br>
  <div class="container">
    <div class="Left">
      <script type="text/javascript">
        let colors = ["#FFFFFF", "#E4E4E4", "#888888", "#222222", "#FFA7D1", "#E50000", "#E59500", "#A06A42", "#E5D900", "#94E044", "#02BE01", "#00D3DD", "#0083C7", "#0000EA", "#CF6EE4", "#820080"];
        let pixels = [];
        for (var i = 0; i < 16; i++) {
          pixels.push([]);
          for (var j = 0; j < 16; j++) {
            pixels[i].push(colors[Math.floor(Math.random()*colors.length)]);
          }
        }
        document.write('<svg viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" class="SVGgrid" width="700px">');
        for (var i = 0; i < 16; i++) {
          for (var j = 0; j < 16; j++) {
            document.write(`<rect x="${j*1.01}" y="${i*1.01}" width="1" height="1" fill="${pixels[i][j]}"/>`);
          }
        }

        document.write('</svg>');
      </script>
    </div>


    <br><br>



    <div class="Right">
      <form method='post'>
        <input type="text" name="x" placeholder="x">
        <input type="text" name="y" placeholder="y">

        <select name="couleur" id="couleurs">
          <script type="text/javascript">
            for (var i = 0; i < colors.length; i++) {
              document.write(`<option value=${colors[i]} style="background-color : "${colors[i]}>${colors[i]}</option>`);
            }
          </script>
        </select>
        <br><br>
        <input type="submit" name="submit" value="Valider" class="button">

      </form>
<br><br>
      <form method='post'>
        <input type="submit" name="deco" value="Déconnexion" class="button">
      </form>
      <?php
      if ($_POST['deco'] == "Déconnexion") {
        #unset($_SESSION);
        session_destroy();
        header('Location: index.php');
      }
      ?>
    </div>
  </div>
</body>

</html>
