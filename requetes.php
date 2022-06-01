<!DOCTYPE html>
<html>
<?php
$requetes = [
  "SELECT * FROM Utilisateur WHERE nom_utilisateur=? AND mot_de_passe=?;",
  "INSERT INTO Utilisateur(nom_utilisateur, mot_de_passe, heure_dernier_pixel) VALUES (?,?,?);",
  "SELECT * FROM Utilisateur;",
  "SELECT * FROM Pixel;"
];

?>
</html>
