<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>r/place : Tableau des utilisateurs les plus actifs</title>
  <link rel="stylesheet" href="styleIndex.css">
</head>
<body>
<h2>Utilisateurs les plus actifs :</h2>
<table>
  <thead>
    <tr>
      <th>Pseudonyme</th>
      <th>Nombre de pixels placés</th>
    </tr>
  </thead>
  <tbody>
      <?php
      include 'requetes.php';
      $pdo = new PDO('sqlite:bdd.sqlite');
      $query = $requetes[7];
      $stmt = $pdo->prepare($query);
      $stmt->execute();
      $resultP = $stmt->fetchAll();
      for ($i=0; $i < count($resultP); $i++) {
        if ($resultP[$i]["nom_utilisateur"]!="admin") {
          echo "<tr><td>".$resultP[$i]["nom_utilisateur"]."</td><td>".$resultP[$i]["nb_pixels_poses"]."</td></tr>";
        }
      }
      $pdo = null;
      ?>
  </tbody>
</table>
<br><br>
<a href="index.php">
   <button class="button">Accueil</button>
</a>
</body>
</html>
