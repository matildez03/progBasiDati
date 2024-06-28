<?php require ('read/validate.php');
if(!isset($_SESSION['login'])){
    header('Location: ../index.php');
    exit;
}
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>pannello di controllo</title>
</head>
<body>
<h1>Inserisci manualmente una query:</h1>
<div id="account">Docente: <?php echo ($_SESSION['login'][2] . $_SESSION['login'][3]);?></div> <!--stampa i dati dell'account-->

<form action="upload/queryExecute.php" method="post">
    <textarea name="query" placeholder="inserisci la tua query qui."></textarea>
    <input type="submit" value="esegui.">
</form>

</body>
</html>
