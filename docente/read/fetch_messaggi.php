<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['login'])) {
    header('Location: ../index.php');
    exit;
}
require "/Applications/MAMP/htdocs/progBasi/config.php";
$test_id = $_SESSION['test'];
$query= "SELECT MESSAGGIO.titolo, MESSAGGIO.testo, MESSAGGIO.id, MESSAGGIO.test, MESSAGGIO.data, TEST.docente, MESSAGGIOPRIVATO.studente FROM MESSAGGIO LEFT JOIN MESSAGGIOPRIVATO ON MESSAGGIO.id = MESSAGGIOPRIVATO.idMessaggio JOIN TEST ON TEST.titolo = MESSAGGIO.test
WHERE test = ?;";
$stmt = $mydb->prepare($query);
$stmt->bind_param('s', $test_id);
$stmt->execute();
$res= $stmt->get_result();
$messaggi = $res->fetch_all(MYSQLI_ASSOC);
//echo json_encode($messaggi);
?>
