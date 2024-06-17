<?php
session_start();
/*
 * mi assicuro che il file sia accesibile solo se è sttao eseguito l'accesso
 */
if(!isset($_SESSION['login'])){
    header('Location: ../index.php');
    exit;
} else{ //il login è stato effettuato
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
<div id="account"><?php echo "Studente: ".$_SESSION['login'][2]." " . $_SESSION['login'][3].""?></div> <!--stampa i dati dell'account-->

<nav>
    <li><a>fai un test</a></li>
    <li><a>statistiche</a></li>
    <li><a>messaggi</a></li>
</nav>

</body>
</html>
