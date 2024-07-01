<?php
require '/Applications/MAMP/htdocs/progBasi/config.php'; //includo la connessione al db
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
error_reporting(E_ALL & ~E_NOTICE);//ignoro le notices
$quesiti='quesiti';
if (isset($_POST['test'])) {
    $test = $_POST['test'];
} if(isset($_SESSION['test'])){
    $test = $_SESSION['test'];
}
// Abilita output buffering
ob_start();
try {
    if (isset($test)) {
        //$query = "SELECT * FROM QUESITO WHERE test = ?";
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
        }
        //echo json_encode($quesiti);
    } else {
        throw new Exception("Nessun test specificato nella richiesta.");
    }
} catch (Exception $e) {
    // Gestione degli errori
    header('HTTP/1.1 500 Internal Server Error');
    echo json_encode(['error' => $e->getMessage()]);
}
$output = ob_get_clean();
echo $output;
