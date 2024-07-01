<?php // Eseguo la query per recuperare i messaggi dalla tabella messaggio
require('/Applications/MAMP/htdocs/progBasi/config.php'); //configurazione con %mydb
$test_id = $_SESSION['test'];
$messaggi = [];
$professore = '';
$titolo = '';
$studente = $_SESSION['login'][0];
// Query per recuperare il testo dei messaggi
$sql_messaggi = "SELECT testo FROM MESSAGGIO WHERE test = ?";
$stmt_messaggi = $mydb->prepare($sql_messaggi);
$stmt_messaggi->bind_param("s", $test_id);
$stmt_messaggi->execute();
$result_messaggi = $stmt_messaggi->get_result();

while ($row = $result_messaggi->fetch_assoc()) {
    $messaggi[] = $row['testo'];
}

//debug
echo json_encode($messaggi);
$stmt_messaggi->close();

// Query per recuperare l'email del professore associato al test
$sql_professore = "SELECT T.docente
                   FROM test T
                   WHERE T.titolo = ?";
$stmt_professore = $mydb->prepare($sql_professore);
$stmt_professore->bind_param("s", $test_id);
$stmt_professore->execute();
$stmt_professore->bind_result($professore_email);

// Fetch del risultato (deve esserci solo una riga di risultato)
if ($stmt_professore->fetch()) {
    $professore = $professore_email;
}

$stmt_professore->close();

// Query per recuperare l'email del professore associato al test
$sql_titolo = "SELECT titolo
                       FROM messaggio
                       WHERE test = ?";
$stmt_titolo = $mydb->prepare($sql_titolo);
$stmt_titolo->bind_param("s", $test_id);
$stmt_titolo->execute();
$stmt_titolo->bind_result($messaggio_titolo);

// Fetch del risultato (deve esserci solo una riga di risultato)
if ($stmt_titolo->fetch()) {
    $titolo = $messaggio_titolo;
}

$stmt_titolo->close();

$query= "SELECT MESSAGGIO.titolo, MESSAGGIO.testo, MESSAGGIO.id, MESSAGGIO.test, MESSAGGIO.data, TEST.docente, MESSAGGIOPRIVATO.studente FROM MESSAGGIO LEFT JOIN MESSAGGIOPRIVATO ON MESSAGGIO.id = MESSAGGIOPRIVATO.idMessaggio JOIN TEST ON TEST.titolo = MESSAGGIO.test
WHERE test = ? AND (studente = ? OR docente = ?);";
$stmt = $mydb->prepare($query);
$stmt->bind_param('sss', $test_id, $studente, $professore);
$stmt->execute();
$res= $stmt->get_result();
$messaggi = $res->fetch_all(MYSQLI_ASSOC);
//echo json_encode($messaggi);

?>
