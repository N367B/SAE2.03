<!DOCTYPE html>
 <html>

 <head>
     <link rel="stylesheet" type="text/css" href="style.css">

 </head>

 <body>

     <div class="container">
         <div class="tl"></div>
         <div class="tm"></div>
         <div class="tr"></div>
         <div class="ml"></div>
         <div class="mm">
             <form method="post">
                 <input type="text" name="username" placeholder="nom">
                 <input type="password" name="password" placeholder="mot de passe">
                 <br><br>
                 <input type="submit" name="submit" value="Connexion" class="button">
                 <input type="submit" name="submit" value="Inscription" class="button">
         </div>
         <div class="mr"></div>
         <div class="bl"></div>
         <div class="bm"></div>
         <div class="br"></div>
     </div>
 </body>

 </html>
 <?php

/*----------------------------*/

if ($_POST['submit']=='Connexion'){
    include 'requetes.php';
    $name = $_POST['username'];
    $pdo = new PDO('sqlite:forum.db');
    $query = $requetes[0];
    $stmt = $pdo->prepare($query);
    $stmt->bindValue(1, $_POST['username'], PDO::PARAM_STR);
    $stmt->bindValue(2, md5($_POST['password']), PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetchAll();
    $pdo = null;
    if (isset($result[0][1])) {
        session_start();
        $_SESSION["newsession"]=$result[0]['id_membre'];
        $_SESSION['username'] = $_POST['username'];
        header('Location: sujets.php');
    }
}

if ($_POST['submit']=='Inscription'){
  include 'requetes.php';
  $name = $_POST['username'];
  $pdo = new PDO('sqlite:forum.db');
  $query = $requetes[1];
  $stmt = $pdo->prepare($query);
  $stmt->bindValue(1, $_POST['username'], PDO::PARAM_STR);
  $stmt->bindValue(2, md5($_POST['password']), PDO::PARAM_STR);
  #$stmt->execute();
  $pdo = null;
  var_dump($_POST['username']);
  echo '<h3>Utilisateur '. $_POST['username'] . ' créé</h3>';
}

    ?>
