<?php if(isset($_SESSION['login'])) {
    session_destroy();
} ?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Accesso Docenti</title>
</head>
<body>
<h1>Accesso Docenti</h1>
<h4>Non hai un account? <a href="registrazioneDocenti.php">Registrati!</a></h4>
<form action="read/validate.php" method="POST">
    <input type="text" name="email" placeholder="email">
    <label>email</label>
    <input type="password" name="pass" placeholder="password">
    <label>password</label>
    <input type="submit" value="accedi" name="login">
</form>
</body>
</html>
