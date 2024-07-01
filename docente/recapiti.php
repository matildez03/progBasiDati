<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['login'])) {
    header('Location: ../index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Aggiungi contatto</title>
</head>
<body>
<form action="upload/salva_contatto.php" method="POST">
    <label>Numero di telefono: <input type="text" name="telefono"></label>
    <input type="submit" value="Invia">
</form>
</body>
</html>
