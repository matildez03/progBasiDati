<?php
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>pannello di controllo</title>
</head>
<body>
<h1>registrati in ESQLQ</h1>

<form action="read/register.php" method="POST">
    <h4>I tuoi dati:</h4>
    <input name="nome" type="text" placeholder="nome">
    <input name="cognome" type="text" placeholder="cognome">
    <input name="email" type="text" placeholder="email">
    <br>
    <label>Numero di Matricola ed anno di immatricolazione: </label>
    <input name="matricola" type="text" placeholder="matricola">
    <input name="anno" type="text" placeholder="anno">
    <br>
    <label>Immetti e ripeti la password</label>
    <input name="pass" type="password" placeholder="password">
    <input name="pass2" type="password">
    <input type="submit" value="registrati">
</form>
</body>
</html>
