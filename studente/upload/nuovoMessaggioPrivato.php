<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['login'])) {
    header('Location: ../index.php');
    exit;
}
require "../../config.php";
//recupero i dati mandati in post
$titolo = $_POST['titolo'];
$testo = $_POST['testo'];
$studente = $_POST['studente'];
$test = trim($_POST['test']);
$data = date('Y-m-d');

echo "<br>titolo: ". $titolo;
echo "<br>test: ". $test;
echo "<br>testo: ". $testo;
//DEBUG
// Verifica se il test esiste nella tabella TEST
$queryCheck = "SELECT COUNT(*) as count FROM TEST WHERE titolo = ?";
$stmtCheck = $mydb->prepare($queryCheck);
$stmtCheck->bind_param('s', $test);
$stmtCheck->execute();
$result = $stmtCheck->get_result();
$row = $result->fetch_assoc();

if ($row['count'] > 0) {
    echo 'test esistente';
} else{
    echo 'test non trovato';
}
$query = "CALL inserisci_messaggioPrivato(?,?,?,?,?);";
$stmt = $mydb->prepare($query);
$stmt->bind_param('sssss', $titolo,$testo,$data, $test, $studente);
if($stmt->execute()){
    //echo 'test avviato.';
    header("Location: ../messaggi.php?titolo=$test");
}else{
    throw new Exception("errore nell'inserimento del messaggio");
}
?>
