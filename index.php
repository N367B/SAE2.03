<!DOCTYPE html>
<html>

<head>
  <link rel="stylesheet" type="text/css" href="styleIndex.css"> <!-- Appel du fichier de style -->
  <title>Accueil</title>
</head>

<body>
  <!--
  Formulaire de connexion / inscription
-->
  <div class="container">
    <div class="tl"></div>
    <div class="tm"></div>
    <div class="tr"></div>
    <div class="ml"></div>
    <div class="mm">
      <form method="post">
        <input type="text" name="username" placeholder="Nom"> <!-- Saisir nom d'utilisateur -->
        <input type="password" name="password" placeholder="Mot de passe" id='password'> <!-- Saisir mot de passe -->
        <a href='#' onclick="toggleViewPassword()">
          <!-- Afficher/masquer mot de passe -->
          <img src="hide.png" alt="ShowHideIcon" id="HideShow" height="25px"> <!-- Icone de masquage/affichage du mot de passe -->
        </a>
        <br><br>
        <input type="submit" name="submit" value="Connexion" class="button"> <!-- Bouton de connexion -->
        <input type="submit" name="submit" value="Inscription" class="button"> <!-- Bouton d'inscription -->
      </form>
      <br><br>
      <a href="stats.php"><button class="button">Statistiques</button></a> <!-- Bouton statistiques-->
    </div>
    <div class="mr"></div>
    <div class="bl"></div>
    <div class="bm"></div>
    <div class="br"></div>
  </div>
</body>

<script type="text/javascript">
  function toggleViewPassword()
  /*
    Fonction qui permet de cacher/afficher le mot de passe, et de changer l'icone de l'affichage du mot de passe.
  */
  {
    var x = document.getElementById("password"); // Recuperation du champ de mot de passe
    var y = document.getElementById("HideShow"); // Recuperation de l'icone de masquage/affichage du mot de passe
    if (x.type === "password") //
    {
      x.type = "text"; // Si le mot de passe est caché, on l'affiche
      y.src = "show.png"; // On change l'icone de l'affichage du mot de passe
    } else {
      x.type = "password"; // Si le mot de passe est affiché, on le cache
      y.src = "hide.png"; // On change l'icone de l'affichage du mot de passe
    }
  }
</script>

</html>

<?php

if (isset($_SESSION))
/* Destruction de la session si elle existe */ {
  session_destroy();
}
/*
  Si le formulaire de connexion est rempli, on vérifie que les informations sont correctes.
  Si elles sont correctes, on crée une session et on redirige vers la page d'accueil.
  Si elles sont incorrectes, on affiche un message d'erreur.
*/
if (isset($_POST['submit'])) {
  if ($_POST['submit'] == 'Connexion') {
    include 'requetes.php';
    $name = $_POST['username']; // Recuperation du nom d'utilisateur
    $pdo = new PDO('sqlite:bdd.sqlite'); // Connexion à la base de données
    $query = $requetes[0]; // Recuperation de la requete de recherche d'un utilisateur
    $stmt = $pdo->prepare($query); // Preparation de la requete
    $stmt->bindValue(1, $_POST['username'], PDO::PARAM_STR); // Bind du nom d'utilisateur
    $stmt->bindValue(2, md5($_POST['password']), PDO::PARAM_STR); // Bind du mot de passe
    $stmt->execute(); // Execution de la requete
    $result = $stmt->fetchAll(); // Recuperation du resultat de la requete
    $pdo = null; // Fermeture de la connexion à la base de données
    if (isset($result[0][1])) {
      session_start(); // Creation de la session
      $_SESSION["session"] = $result[0]['identifiant_utilisateur']; // Attribution de l'identifiant de l'utilisateur a la session
      $_SESSION['username'] = $_POST['username']; // Attribution du nom d'utilisateur a la session
      $_SESSION['color'] = 'black'; // Attribution de la couleur par defaut a la session
      header('Location: place.php'); // Redirection vers la page d'accueil
    } else {
      echo "<h3>Identifiant ou mot de passe incorrecte<h3>";
    }
  }

  /*
  Si le formulaire d'inscription est rempli, on vérifie que les informations sont correctes avec checkName().
  Si elles sont correctes, on crée l'utilisateur et on affiche un message de confirmation.
  Si elles sont incorrectes, on affiche un message d'erreur.
  */
  if ($_POST['submit'] == 'Inscription') {
    $name = $_POST['username'];
    if (checkName($name)) {
      include 'requetes.php';
      $pdo = new PDO('sqlite:bdd.sqlite');
      $query = $requetes[1]; // Requete d'insertion d'un utilisateur
      $stmt = $pdo->prepare($query);
      $stmt->bindValue(1, $_POST['username'], PDO::PARAM_STR); // Attribution du nom d'utilisateur
      $stmt->bindValue(2, md5($_POST['password']), PDO::PARAM_STR); // Attribution du mot de passe
      $stmt->bindValue(3, microtime(true) - 60, PDO::PARAM_STR); // Attribution de la date dernier pixel - 60 secondes
      $stmt->bindValue(4, 0, PDO::PARAM_INT); // Attribution du nombre de pixels a 0
      $stmt->execute();
      $pdo = null;
      echo '<h3>Utilisateur ' . $_POST['username'] . ' créé</h3>'; // Affichage du message de confirmation
    } else {
      echo "<h3>Mauvais identifiant</h3>"; // Affichage du message d'erreur
    }
  }
} else {
}

function checkName($name)
/*
  Vérifie que le nom d'utilisateur est correct.
  Le nom d'utilisateur ne doit pas contenir d'espaces.
  Le nom d'utilisateur doit être unique.
*/
{
  if ($name == str_replace(' ', '', $name)) {
    include 'requetes.php';
    $pdo = new PDO('sqlite:bdd.sqlite');
    $query = $requetes[2]; // Requête de recherche des utilisateurs
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $resultA = $stmt->fetchAll();
    $pdo = null;
    foreach ($resultA as $A) {
      if ($A[1] == $name) {
        return False; // Si le nom d'utilisateur existe déjà, on retourne false
      }
    }
    return True; // Si le nom d'utilisateur n'existe pas, on retourne true
  } else {
    return False; // Si le nom d'utilisateur contient des espaces, on retourne false
  }
}



?>