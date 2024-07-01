<?php
// funzione per eseguire la query select di tutti i test eseguiti dallo studente

require('/Applications/MAMP/htdocs/progBasi/config.php'); //includo la connessione al db
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
error_reporting(E_ALL & ~E_NOTICE);//ignoro le notices
$tests = '';
// creo la query
$query="SELECT * FROM TEST;";
$res = $mydb->query($query);
$allTests = mysqli_fetch_all($res); //salvo tutte le righe risultanti in un array Associativo
?>