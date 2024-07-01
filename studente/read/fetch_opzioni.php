<?php
require('/Applications/MAMP/htdocs/progBasi/config.php'); //includo la connessione al db
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$test = $_SESSION['test']; //test in sessione
$quesito = $_SESSION['quesito'];
$num = $quesito['num'];
$query = "SELECT * FROM OPZIONE WHERE test = ? AND quesito = ?";
$stmt = $mydb->prepare($query);
$stmt->bind_param("si", $test, $num);
$stmt->execute();
$result = $stmt->get_result();
if (!$result) {
    throw new Exception("Esecuzione della query fallita: " . $stmt->error);
}
$opzioni = $result->fetch_all(MYSQLI_ASSOC); //salvo in un array tutti i valori salvati come array associativi

//echo ('<br>fetch_opz:' . json_encode($opzioni));
?>
