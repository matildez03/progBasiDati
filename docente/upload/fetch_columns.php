<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require('../validate.php'); // Connessione e login
error_reporting(E_ALL & ~E_NOTICE);//ignoro le notices

// Abilita output buffering
ob_start();

try {
    if (isset($_POST['table'])) {
        $table = $_POST['table'];
        $query = "SELECT nome FROM ATTRIBUTO WHERE nomeTabella = ?";
        $stmt = $mydb->prepare($query);
        $stmt->bind_param("s", $table);
        $stmt->execute();
        $result = $stmt->get_result();
        if (!$result) {
            throw new Exception("Esecuzione della query fallita: " . $stmt->error);
        }
        $columns = array();
        while ($row = $result->fetch_assoc()) {
            $columns[] = $row['nome'];
        }
        if (empty($columns)) {
            throw new Exception("Nessuna colonna trovata per la tabella: " . $table);
        }
        echo json_encode($columns);
    } else {
        throw new Exception("Nessuna tabella specificata nella richiesta.");
    }
} catch (Exception $e) {
    // Gestione degli errori
    header('HTTP/1.1 500 Internal Server Error');
    echo json_encode(['error' => $e->getMessage()]);
}

// Pulisce qualsiasi output imprevisto e cattura solo il contenuto JSON
$output = ob_get_clean();
echo $output;
?>

