<!DOCTYPE html>
<html>
<?php
$requetes = [
  "SELECT * FROM Utilisateur WHERE nom_utilisateur=? AND mot_de_passe=?;",
  "INSERT INTO Utilisateur(nom_utilisateur, mot_de_passe, heure_dernier_pixel) VALUES (?,?,?);",
  "SELECT * FROM Utilisateur;",
  "SELECT * FROM Pixel;",
  "UPDATE Pixel SET couleur = ?, identifiant_utilisateur = ? WHERE coordonne_x = ? AND coordonne_y = ?;",
  "UPDATE Utilisateur SET heure_dernier_pixel = ? WHERE identifiant_utilisateur = ?",
  "SELECT heure_dernier_pixel FROM Utilisateur WHERE identifiant_utilisateur = ?"
];

?>
</html>
