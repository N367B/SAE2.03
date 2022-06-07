<?php
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
