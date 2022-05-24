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


    <?php
    include 'requetes.php';
    echo '<h3>'."Vous êtes connecté en tant que " . $_SESSION['username'].'</h3>';
    #------------------
    # Récupération des sujets
    #------------------
    $pdo = new PDO('sqlite:bdd.sqlite');
    $query = $requetes[2];
    $stmt = $pdo->prepare($query);
    //$stmt->bindValue(1, $name, PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetchAll();
    $pdo = null;
    ?>

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
