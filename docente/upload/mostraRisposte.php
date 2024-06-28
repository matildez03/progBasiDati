<?php
require '../../config.php'; //includo la connessione al db
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
error_reporting(E_ALL & ~E_NOTICE);//ignoro le notices
// Abilita output buffering
ob_start();
header("Content-Type: application/json");
try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Ottieni i parametri POST
        $test = isset($_POST['test']) ? $_POST['test'] : null;
        $show = isset($_POST['show']) ? $_POST['show'] : null;

        if ($test === null || $show === null) {
            throw new Exception("Parametri mancanti nella richiesta.");
        }
        $query = "UPDATE TEST SET visualizzaRisposte = ? WHERE titolo = ?";
        $stmt = $mydb->prepare($query);
        $stmt->bind_param('is', $show, $test);
        if($stmt->execute()) {
            echo "query eseguita con successo.";
        } else{
            echo "errore nell'esecuzione della query.";
        }
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