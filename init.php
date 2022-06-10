<!DOCTYPE html>
<html>

<head>
  <link rel="stylesheet" type="text/css" href="styleIndex.css"> <!-- Liaison avec le CSS -->
  <title>Initialisation</title>
</head>

<body>
  <h2>Voulez vous creer une nouvelle base de données (supprimer l'existante)</h2> <!-- Titre de la page -->
  <form method="get">
    <input type="text" name="validation" placeholder="oui/non"> <!-- Saisir oui/non -->
    <br><br>
    <input type="submit" name="submit" value="Valider" class="button"> <!-- Bouton de validation -->
  </form>


  <?php
  session_start(); // On démarre la session
  echo '<br><br><a href="index.php"><button class="button">Retour à l\'accueil</button></a>'; // Bouton retour à l'accueil
  echo '<br><br><a href="place.php"><button class="button">Retour sur le caneva</button></a>'; // Bouton retour sur le caneva
  if ($_SESSION['session'] == 1 and $_GET["validation"] == "oui")
  /*
    Si c'est un admin (id = 1) et que l'utilisateur a cliqué sur "oui"
    On supprime la base de données et l'initialise.
   */ {
    unlink('bdd.sqlite');
    $database = new PDO('sqlite:bdd.sqlite');
    $database->exec("CREATE TABLE `Pixel` ( `coordonne_x` INTEGER, `coordonne_y` INTEGER, `identifiant_utilisateur` TEXT NOT NULL, `couleur` TEXT, FOREIGN KEY(`identifiant_utilisateur`) REFERENCES `Utilisateur`(`identifiant_utilisateur`), PRIMARY KEY(`coordonne_x`,`coordonne_y`) );"); // Creation de la table Pixel
    $database->exec("CREATE TABLE `Utilisateur` ( `identifiant_utilisateur` INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE, `nom_utilisateur` TEXT NOT NULL UNIQUE, `mot_de_passe` TEXT NOT NULL, `heure_dernier_pixel` TEXT NOT NULL, `nb_pixels_poses`  INTEGER);"); // Creation de la table Utilisateur
    $rqt = "INSERT INTO Utilisateur (nom_utilisateur, mot_de_passe, heure_dernier_pixel, nb_pixels_poses) VALUES (?,?,?,?);";
    $stmt = $database->prepare($rqt);
    $stmt->bindValue(1, 'admin', PDO::PARAM_STR); // Nom de l'utilisateur admin
    $stmt->bindValue(2, md5('admin'), PDO::PARAM_STR); // Mot de passe admin
    $stmt->bindValue(3, microtime(true), PDO::PARAM_STR); // Heure de la derniere modification du pixel
    $stmt->bindValue(4, 0, PDO::PARAM_INT); // Nombre de pixels poses
    $stmt->execute();
    $rqt = "INSERT INTO Pixel (coordonne_x, coordonne_y, couleur, identifiant_utilisateur) VALUES (?,?,?,?);";  // Creation des pixels
    /*
    On initialise la base de données avec des pixels de couleur blanc.
  */
    for ($i = 0; $i < 16; $i++) {
      for ($j = 0; $j < 16; $j++) {
        $stmt = $database->prepare($rqt);
        $stmt->bindValue(1, $i, PDO::PARAM_INT);
        $stmt->bindValue(2, $j, PDO::PARAM_INT);
        $stmt->bindValue(3, 'white', PDO::PARAM_STR); // Couleur blanc
        $stmt->bindValue(4, 1, PDO::PARAM_INT); // Identifiant de l'utilisateur admin
        $stmt->execute();
      }
    }
    $database = NULL;
    echo "<p>Base de donnée initialisée.</p>"; // Message de confirmation
    echo "<a href=\"index.php\">Retour à l'accueil</a>"; // Bouton retour à l'accueil
  }
  ?>
</body>

</html>