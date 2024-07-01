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
}
require ('read/validate.php');

?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <script type="text/javascript" src="script.js"></script>
    <title>Test</title>
</head>
<body>
<h1>I tuoi test:</h1>
<div id="account"><?php echo "Docente: " . $_SESSION['login'][2] . " " . $_SESSION['login'][3] . "" ?></div>
<!--stampa i dati dell'account-->

<ul id="elencoTest">
    <input type="button" value="Nuovo test" onclick="showCreate()">
    <?php foreach ($_SESSION['tests'] as $test) {
        echo '<li><a href="aggiornaTest.php?titolo='.$test['titolo'].'&show='.urlencode($test['visualizzaRisposte']).'">' . $test['titolo'] . '</a></li>';
    } ?>
</ul>
<form id="nuovoTest" action="upload/createTest.php" method="POST" style="display: none">
    <label>Titolo Test:<input type="text" name="titoloTest" required></label>
    <select name="mostraSoluz">
        <option value="1">Mostra soluzioni</option>
        <option value="0" selected>Nascondi soluzioni</option>
    </select>
    <input type="file" name="image" accept="image/" value="nessuna immagine selezionata">
    <input type="submit">
</form>

</body>
</html>
