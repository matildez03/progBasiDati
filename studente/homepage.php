<?php

/*
 * mi assicuro che il file sia accesibile solo se è sttao eseguito l'accesso
 */
session_start();
if(!isset($_SESSION['login'])){
    header('Location: ../index.php');
    exit;
}

?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>pannello di controllo</title>
</head>
<body>
<h1>Amministrazione di ESQL</h1>
<div id="account">
    <?php echo "Studente: ".$_SESSION['login'][2]." " . $_SESSION['login'][3].""?>
    <a href="../logout.php">Logout</a>
</div>

<nav>
    <li><a href="areaTest.php">fai un test</a></li>
    <li><a href="../statistiche.php">statistiche</a></li>
    <li><a href="messaggi.php">messaggi</a></li>
</nav>

</body>
</html>
