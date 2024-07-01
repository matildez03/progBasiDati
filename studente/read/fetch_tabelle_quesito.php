<?php
require ('/Applications/MAMP/htdocs/progBasi/config.php'); //includo la connession al db $mydb
require('/Applications/MAMP/htdocs/progBasi/studente/config-esercizi-studente.php'); //includo la connessione al db $esdb

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$test = $_SESSION['test']; //test in sessione
if(isset($_SESSION['quesito'])) {
    $quesito = $_SESSION['quesito'];
}
$num = $quesito['num'];
$query = "SELECT tabella FROM RIFTABELLE WHERE test = ? AND num = ?";
$stmt = $mydb->prepare($query);
$stmt->bind_param("si", $test, $num);
$stmt->execute();
$result = $stmt->get_result();
if (!$result) {
    throw new Exception("Esecuzione della query fallita: " . $stmt->error);
}
$tabelle = [];
while ($row = $result->fetch_assoc()) {
    $tabelle[] = $row['tabella'];
}
//echo ('<br>tabelle:' . $num. json_encode($tabelle));

//una volta trovate i nomi delle tabelle, prelevo i dati delle tabelle stesse dal db ESQL-ESERCIZI

?>
