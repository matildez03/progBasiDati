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
    <h4>Dati di accesso al database</h4>
    <input name="usdb" type="text">
    <input name="pwdb" type="password">
    <h4>I tuoi dati:</h4>
    <input name="nome" type="text" placeholder="nome">
    <input name="cognome" type="text" placeholder="cognome">
    <input name="email" type="text" placeholder="email">
    <br>
    <label> Dipartimento e corso di insegnamento: </label>
    <input name="dipartimento" type="text" placeholder="dipartimento">
    <input name="corso" type="text" placeholder="corso">
    <br>
    <label>Immetti e ripeti la password</label>
    <input name="pass" type="password" placeholder="password">
    <input name="pass2" type="password">


    <input type="submit" value="registrati">
</form>
</body>
</html>
