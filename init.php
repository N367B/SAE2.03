<?php
  $database = new PDO('sqlite:bdd.sqlite');
  $database->exec("CREATE TABLE `Pixel` ( `coordonne_x` INTEGER, `coordonne_y` INTEGER, `identifiant_utilisateur` TEXT NOT NULL, `couleur` TEXT, FOREIGN KEY(`identifiant_utilisateur`) REFERENCES `Utilisateur`(`identifiant_utilisateur`), PRIMARY KEY(`coordonne_x`,`coordonne_y`) );");
  $database->exec("CREATE TABLE `Utilisateur` ( `identifiant_utilisateur` INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE, `nom_utilisateur` TEXT NOT NULL UNIQUE, `mot_de_passe` TEXT NOT NULL, `heure_dernier_pixel` TEXT NOT NULL );");
  $rqt="INSERT INTO Utilisateur (nom_utilisateur, mot_de_passe, heure_dernier_pixel) VALUES (?,?,?);";
  $stmt=$database->prepare($rqt);
  $stmt->bindValue(1,'admin',PDO::PARAM_STR);
  $stmt->bindValue(2,md5('admin'),PDO::PARAM_STR);
  $stmt->bindValue(3,date('Y-m-d H:i:s'),PDO::PARAM_STR);
  $stmt->execute();
  $rqt="INSERT INTO Pixel (coordonne_x, coordonne_y, couleur, identifiant_utilisateur) VALUES (?,?,?,?);";
  for ($i=0; $i < 16 ; $i++) {
    for ($j=0; $j < 16 ; $j++) {
      $stmt=$database->prepare($rqt);
      $stmt->bindValue(1,$i,PDO::PARAM_INT);
      $stmt->bindValue(2,$j,PDO::PARAM_INT);
      $stmt->bindValue(3,'white',PDO::PARAM_STR);
      $stmt->bindValue(4,1,PDO::PARAM_INT);
      $stmt->execute();
    }
  }
  $database=NULL;
  echo "Base de donnée initialisée.";
  header('Location: index.php');
?>
