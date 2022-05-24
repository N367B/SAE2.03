<?php
session_start();
 if (count($_SESSION) == 0){
     header('Location: index.php');
 }
?>


<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" type="text/css" href="style.css">

</head>

<body>

  <script type="text/javascript">
    var colors = ["white", "black", 'red', 'blue', 'green'];
    document.write('<svg viewBox="0 0 15 15" xmlns="http://www.w3.org/2000/svg">');
    for (var i = 0; i < 6; i++) {
      for (var j = 0; j < 6; j++) {
        document.write(`<rect x="${i*1.01}" y="${j*1.01}" width="1" height="1" fill="${colors[0]}"/>`);
      }
    }

    document.write('</svg>');
  </script>




    <?php
    include 'requetes.php';
    echo '<h3>'."Vous êtes connecté en tant que " . $_SESSION['username'].'</h3>';
    ?>
<br>
    <form method='post'>
    <input type="submit" name="deco" value="Déconnexion" class="button">
</form>
<?php
if ($_POST['deco'] == "Déconnexion"){
    #unset($_SESSION);
    session_destroy();
    header('Location: index.php');
}
?>
</body>



<?php
if ($_POST['submit'] == 'nouveau') {
    include 'requetes.php';
    $name = $_POST['nom'];
    $pdo = new PDO('sqlite:bdd.sqlite');
    $query = $requetes[4];
    $stmt = $pdo->prepare($query);
    $stmt->bindValue(1, $_POST['sujet'], PDO::PARAM_STR);
    $stmt->bindValue(2, date('Y-m-d H:i:s'), PDO::PARAM_STR);
    $stmt->bindValue(3, $_SESSION['newsession'], PDO::PARAM_STR);
    $stmt->execute();
    $pdo = null;
    header("Refresh:1");
}
?>

</html>
