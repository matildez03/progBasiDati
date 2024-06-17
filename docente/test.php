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
    <script type="text/javascript" src="script.js"></script>
    <title>test</title>
</head>
<body>
<h1>I tuoi test:</h1>
<div id="account"><?php echo "Docente: ".$_SESSION['login'][2]." " . $_SESSION['login'][3].""?></div> <!--stampa i dati dell'account-->

<nav id="elencoTest">
</nav>

</body>
</html>
<script>

</script>