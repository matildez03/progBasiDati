<?php
//recupera le risposte dell'utente in sessione e del test in sessione
require('/Applications/MAMP/htdocs/progBasi/config.php'); //includo la connessione al db
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$test = $_SESSION['test']; //test in sessione
$studente = $_SESSION['login'][0]; //email dello studente in sessione
$query = "SELECT testo FROM RISPOSTA WHERE test = ? AND studente = ? ORDER BY numeroQuesito";
$stmt = $mydb->prepare($query);
$stmt->bind_param("ss", $test, $studente);
$stmt->execute();
$result = $stmt->get_result();
if (!$result) {
    throw new Exception("Esecuzione della query fallita: " . $stmt->error);
}
$risposte = $result->fetch_all( ); //salvo in un array tutti i testi delle risposte

echo 'studente: '. $studente;
echo '<br>test:'. $test;
echo '<br>fetch_risp: risposte: '. json_encode($risposte);
?>
