<?php @include 'config.php' ?>
<!DOCTYPE html>
<html lang="it">
<script type="text/javascript" src="../script.js"></script>
<style>
    #registrazione{
        display: flex;
        flex-direction: column;
    }
</style>
<head>
    <meta charset="UTF-8">
    <title>Registrazione Docenti</title>
</head>
<body>
<h1>Registrati come Docente</h1>
<div>
    <h4>accesso al db</h4>
    <input type="text" id="udb" name="udb">
    <label>username</label>
    <input type="text" id ="pdb" name="pdb">
    <label>password</label>
    <button onclick="show()">crea account</button>
</div>
<h4 id="ok"></h4>
<form id="registrazione" action="register.php" method="POST" style="visibility: hidden; display: block">
    <input type="text" name="email" placeholder="email">
    <label>email</label>
    <input type="text" name="nome">
    <label>nome</label>
    <input type="text" name="cognome">
    <label>cognome</label>
    <input type="text" name="dipartimento">
    <label>dipartimento</label>
    <input type="text" name="corso">
    <label>corso di insegnamento</label>
    <input type="password" name="password" placeholder="password">
    <label>password</label>
    <input type="submit" value="accedi">
</form>
</body>
</html>
