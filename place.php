<?php
/*
  Lancement de la session.
  Verification de l'existence de la session.
  Si elle n'existe pas, on redirige vers la page de connexion.
*/
session_start();
if (count($_SESSION) == 0) {
  header('Location: index.php'); // Redirection vers la page de connexion.
}
?>

<!DOCTYPE html>

<html>

<head>
  <link rel="stylesheet" type="text/css" href="stylePlace.css"> <!-- Appel du fichier de style -->
</head>

<body>

  <?php

  function getTime($id)
  /*
    Fonction qui retourne l'heure de la derniere modification d'un utilisateur (id), en secondes UNIX.
  */
  {
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
  function GoToNow($url)
  {
    echo '<script language="javascript">window.location.href ="' . $url . '"</script>';
  }


  echo '<h3>' . "Vous êtes connecté en tant que " . $_SESSION['username'] . '</h3>'; //Message d'accueil

  /*
    Recuperation de la table Pixel.
  */
  include 'requetes.php';
  $pdo = new PDO('sqlite:bdd.sqlite');
  $query = $requetes[3];
  $stmt = $pdo->prepare($query);
  $stmt->execute();
  $resultP = $stmt->fetchAll();
  $pdo = null;

  /*
 Cration d'un tableau vide (16*16) qui contiendra les pixels
*/
  $pixels = [];
  for ($i = 0; $i < 16; $i++) {
    array_push($pixels, []); // Creation d'un tableau de 16 lignes
    for ($j = 0; $j < 16; $j++) {
      array_push($pixels[$i], ''); // Creation d'un tableau de 16 colonnes
    }
  }


  /*
    Mise en forme du tableau de pixels.
  */
  for ($i = 0; $i < count($resultP); $i++) {
    $pixels[$resultP[$i][0]][$resultP[$i][1]] = $resultP[$i][3]; // On met les pixels dans le tableau
  }
  ?>

  <script src="choix.js"></script>

  <br><br>

  <div class="container">

    <div class="Left">

      <script type="text/javascript">
        let pixels = <?php echo json_encode($pixels); ?>; // Recuperation de la liste des couleurs depuis PHP.

        /*
          Affichage du tableau de pixels, en fonction des couleurs/coordonnees.
        */
        document.write('<svg viewBox="0 0 17 17" xmlns="http://www.w3.org/2000/svg" class="SVGgrid" width="700px">'); // Creation du SVG
        for (var i = 0; i < 16; i++) {
          for (var j = 0; j < 16; j++) {
            document.write(`<rect x="${j}" y="${i}" width="1" height="1" fill="${pixels[i][j]}" id="${j}-${i}" onclick="recup(${j},${i})"/>`); // Creation des rectangles (pixels) et attribution des couleurs en fonction des coordonnees
          }
        }
        evenements(); // Ajout des evenements
        document.write('</svg>'); // Fin du SVG
      </script>

    </div>

    <br><br>

    <!--Formulaire-->
    <div class="Right">
      <form id="formulaire" name="formulaire" method='post'>
        <!-- Creation du formulaire -->
        <input type="text" id="x" name="x" placeholder="Colonne"> <!-- Creation du champ de saisie de la colonne -->
        <input type="text" id="y" name="y" placeholder="Ligne"> <!-- Creation du champ de saisie de la ligne -->
        <input type="color" id="head" name="head" value=<?php echo $_SESSION['color']; ?>> <!-- Creation du champ de saisie de la couleur -->
        <br><br>
        <input type="submit" name="btnSubmit" value="Valider" class="button" id='ValidPixel'> <!-- Creation du bouton de validation -->
      </form>


      <?php
      $URL = "place.php";
      if (isset($_POST["x"]))
      /*
        Si le bouton Valider est cliqué :
         - Verification de l'heure de la derniere modification (difference en secondes entre l'heure derniere modification et l'heure actuelle superieure a 60 secondes) ou que l'utilisateur est un Admin (id = 1).
          - Si c'est le cas, on modifie le pixel dans la base de donnees et la date de derniere modification, et rafraichissement de la page.
          - Si c'est pas le cas, on affiche un message d'erreur indiquant le temps restant avant la modification.
      */ {
        $_SESSION['color'] = $_POST['head'];
        if (microtime(true) - getTime($_SESSION['session']) > 60 or $_SESSION['session'] == 1) // Verification de l'heure de la derniere modification
        {
          $UCouleur = $_POST["head"]; // Recuperation de la couleur
          $Ux = $_POST["y"]; // Recuperation de la ligne
          $Uy = $_POST["x"]; // Recuperation de la colonne
          $Uid = $_SESSION['session']; // Recuperation de l'id de l'utilisateur

          include 'requetes.php';

          $pdo = new PDO('sqlite:bdd.sqlite');
          $query = $requetes[4]; // Requete de modification du pixel
          $stmt = $pdo->prepare($query);
          $stmt->bindValue(1, $UCouleur, PDO::PARAM_STR);
          $stmt->bindValue(2, $Uid, PDO::PARAM_STR);
          $stmt->bindValue(3, $Ux, PDO::PARAM_STR);
          $stmt->bindValue(4, $Uy, PDO::PARAM_STR);
          $stmt->execute();
          $pdo = null;

          $pdo = new PDO('sqlite:bdd.sqlite');
          $query = $requetes[5]; // Requete de modification de la date de derniere modification
          $stmt = $pdo->prepare($query);
          $stmt->bindValue(1, microtime(true), PDO::PARAM_STR);
          $stmt->bindValue(2, $Uid, PDO::PARAM_STR);
          $stmt->bindValue(3, $Uid, PDO::PARAM_STR);
          $stmt->execute();
          $pdo = null;

          echo "<script type='text/javascript'>document.location.href='{$URL}';</script>";
          echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';
          //header("Refresh:0");
        } else {
          /*
            Affichage du compteur de temps restant avant la modification.
          */
          echo '<p id=\'countdown\'></p>';
          echo '<script>var timeleft =' . round(60 - (microtime(true) - getTime($_SESSION['session']))) . ';';
          echo 'document.getElementById("ValidPixel").style.color = "black";document.getElementById("ValidPixel").disabled = true;';
          echo 'var timer = setInterval(function(){if(timeleft <= 0){clearInterval(timer);document.getElementById("countdown").innerHTML = "C\'est bon !";document.getElementById("ValidPixel").style.color = "";document.getElementById("ValidPixel").disabled = false;} else {document.getElementById("countdown").innerHTML = \'Il reste \' + timeleft + " secondes";}timeleft -= 1;}, 1000);';
          echo ' </script>';
          //echo "<p>Attendez " . round(60 - (microtime(true) - getTime($_SESSION['session']))) . " secondes</p>";
        }
      }
      ?>

      <br><br>
      <!--Formulaire-->
      <form method='post'>
        <input type="submit" name="deco" value="Déconnexion" class="button"> <!-- Creation du bouton de deconnexion -->
      </form>

      <?php


      if (isset($_POST['deco']))
      /*
        Si le bouton Deconnexion est cliqué :
         - On supprime la session de l'utilisateur.
         - On redirige l'utilisateur vers la page d'accueil.
      */ {
        if ($_POST['deco'] == "Déconnexion") {
          session_destroy(); // Suppression de la session
          $URL = 'index.php';
          echo "<script type='text/javascript'>document.location.href='{$URL}';</script>";
          echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';
          //header('Location: index.php'); // Redirection vers la page d'accueil
        }
      }
      ?>
    </div>
  </div>

</body>

</html>