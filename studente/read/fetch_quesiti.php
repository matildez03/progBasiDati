<?php
// recupera i quesiti in base al test definito in sessione
require('/Applications/MAMP/htdocs/progBasi/config.php'); //includo la connessione al db
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$test = $_SESSION['test']; //test in sessione
/* senza stored
$query = "SELECT * FROM QUESITO WHERE test = ?";
$stmt = $mydb->prepare($query);
$stmt->bind_param("s", $test);
$stmt->execute();
$result = $stmt->get_result();
if (!$result) {
    throw new Exception("Esecuzione della query fallita: " . $stmt->error);
}
$quesiti = $result->fetch_all(MYSQLI_ASSOC); //salvo in un array tutti i valori salvati come array associativi
*/
$query = "CALL Visualizza_Quesiti(?);";
$stmt = $mydb->prepare($query);
$stmt->bind_param("s", $test);
$stmt->execute();
$result = $stmt->get_result();
if (!$result) {
    throw new Exception("Esecuzione della query fallita: " . $stmt->error);
}
$quesiti = $result->fetch_all(MYSQLI_ASSOC); //salvo in un array tutti i valori salvati come array associativi
if (empty($quesiti)) {
    throw new Exception("Nessun quesito trovato per il test: " . $test);
} //echo json_encode($quesiti);

?>