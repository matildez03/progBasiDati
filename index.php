<?php
echo 'Versione di PHP: ' . phpversion();
@include 'config-database.php';
session_destroy(); //se c'era una sessione in corso, il ritorno ad index comporta il logout
session_start();
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Homepage</title>
</head>
<body>
<h1>Benvenuto su <b>ESQL</b></h1>
<button onclick="window.location.href='docente/loginDocente.php'">Sono un docente</button>
<button onclick="window.location.href='studente/loginStudente.php'">Sono uno studente</button>
</body>
</html>