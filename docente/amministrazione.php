<?php
/*
 * mi assicuro che il file sia accesibile solo se è sttao eseguito l'accesso
 */
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['login'])) {
    header('Location: ../index.php');
    exit;
} else { //il login è stato effettuato
    echo $_SESSION['login'][0];
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
    <?php echo "Docente: " . $_SESSION['login'][2] . " " . $_SESSION['login'][3] . "" ?>
    <a href="../logout.php">Logout</a>
</div> <!--stampa i dati dell'account-->

<nav>
    <li><a href="test.php">I tuoi test</a></li>
    <li><a href="tabelle.php">Le tue tabelle</a></li>
    <li><a href="../statistiche.php">Statistiche</a></li>
    <li><a href="messaggi.php">Messaggi</a></li>
    <li><a href="queryInput.php">Fai una query</a></li>
    <li><a href="recapiti.php">Aggiungi un recapito telefonico</a></li>

</nav>

</body>
</html>
