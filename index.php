<?php
if(isset($_SESSION['login'])) {
    $_SESSION['login']= null;
    require('logout.php'); //esegue il logout se c'era una sessione in corso
}
//require ('config_logs.php');
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