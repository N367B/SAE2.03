<!DOCTYPE html>
<html>
<?php
/*
  Liste des requetes SQL.
*/
$requetes = [
  "SELECT * FROM Utilisateur WHERE nom_utilisateur=? AND mot_de_passe=?;", // Recherche d'un utilisateur en fonction de son nom et de son mot de passe.
  "INSERT INTO Utilisateur(nom_utilisateur, mot_de_passe, heure_dernier_pixel) VALUES (?,?,?);", // Inscription d'un utilisateur.
  "SELECT * FROM Utilisateur;", // Recuperation de la liste des utilisateurs.
  "SELECT * FROM Pixel;", // Recuperation de la liste des pixels.
  "UPDATE Pixel SET couleur = ?, identifiant_utilisateur = ? WHERE coordonne_x = ? AND coordonne_y = ?;", // Modification d'un pixel.
  "UPDATE Utilisateur SET heure_dernier_pixel = ? WHERE identifiant_utilisateur = ?", // Modification de l'heure de la derniere modification d'un pixel.
  "SELECT heure_dernier_pixel FROM Utilisateur WHERE identifiant_utilisateur = ?" // Recuperation de l'heure de la derniere modification d'un pixel.
];

?>

</html>