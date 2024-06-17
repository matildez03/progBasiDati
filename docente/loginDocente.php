<?php @include 'config.php' ?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Accesso Docenti</title>
</head>
<body>
<h1>Accesso Docenti</h1>
<form action="validate.php" method="POST">
    <input type="text" name="email" placeholder="email">
    <label>email</label>
    <input type="password" name="pass" placeholder="password">
    <label>password</label>
    <input type="submit" value="accedi" name="login">
</form>
<a href='registrazione/registrazioneDocente.php'>Registrati</a>
</body>
</html>
