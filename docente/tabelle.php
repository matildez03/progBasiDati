<?php
require('config.php');
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
    <script type="text/javascript" src="script.js"></script>
</head>
<body>
<h1>Amministrazione di ESQL</h1>
<div id="account">
    <?php echo "Docente: ".$_SESSION['login'][2]." " . $_SESSION['login'][3].""?>
    <a href="logout.php">Logout</a>
</div> <!--stampa i dati dell'account-->
<form name="newTable" action="upload/create.php" method="POST">
    <label for="titolo">Dai un titolo alla tua tabella</label>
    <input name="titolo" type="text" placeholder="titolo della tabella" required>
    <label>Inserisci gli attributi:</label>
    <ol id="listaAttributi">
        <li>
            <label>Nome attributo:</label>
            <input name="att[]" type="text" required>
            <select name="tipo[]" required> Tipo:
                <option name="int">INT</option>
                <option name="text">TEXT</option>
                <option name="boolean">BOOLEAN</option>
                <option name="varchar">VARCHAR</option>
                <option name="date">DATE</option>
            </select>
            <label>Lunghezza caratteri (facoltativo):</label>
            <input name="len[]" type="text">
        </li>
    </ol>
    <input type="button" value="aggiungi attributo" onclick="newAttributo()">
    <input type="submit">
</form>
</body>
</html>
