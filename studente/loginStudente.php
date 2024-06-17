<?php @include 'config.php' ?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Accesso Studenti</title>
</head>
<body>
<h1>Accesso Studenti</h1>
<form action="validate.php" method="POST">
    <input type="text" name="email" placeholder="email">
    <label>email</label>
    <input type="password" name="pass" placeholder="password">
    <label>password</label>
    <input type="submit" value="accedi" name="loginStudente">
</form>

</body>
</html>
