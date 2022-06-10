<!doctype html>
<html lang="fr">

<head>
  <meta charset="utf-8">
  <title>Stats</title>
  <link rel="stylesheet" href="styleIndex.css"> <!-- Appel du fichier de style -->
</head>

<body>
  <h2>Utilisateurs les plus actifs :</h2> <!-- Titre de la page -->
  <table>
    <thead>
      <tr>
        <th>Pseudonyme</th> <!-- Colonne 1 : Pseudonyme -->
        <th>Nombre de pixels placés</th> <!-- Colonne 2 : Nombre de pixels placés -->
      </tr>
    </thead>
    <tbody>
      <?php
      include 'requetes.php';
      $pdo = new PDO('sqlite:bdd.sqlite');
      $query = $requetes[7]; // Recuperation de la liste des utilisateurs.
      $stmt = $pdo->prepare($query);
      $stmt->execute();
      $resultP = $stmt->fetchAll();
      for ($i = 0; $i < count($resultP); $i++) {
        if ($resultP[$i]["nom_utilisateur"] != "admin") // On ne veut pas afficher l'utilisateur admin 
        {
          if ($resultP[$i]["nb_pixels_poses"] != 0) {
            echo "<tr><td>" . $resultP[$i]["nom_utilisateur"] . "</td><td>" . $resultP[$i]["nb_pixels_poses"] . "</td></tr>"; // On ne veut pas afficher les utilisateurs n'ayant posé aucun pixel.
          }
        }
      }
      $pdo = null;
      ?>
    </tbody>
  </table>
  <br><br>
  <a href="index.php">
    <button class="button">Accueil</button> <!-- Bouton retour -->
  </a>
</body>

</html>