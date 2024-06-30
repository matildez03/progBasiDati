<?php
//file che salva le istanze di una tabella in un array associativo $records
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['login'])) {
    header('Location: ../index.php');
    exit;
}
require ('/Applications/MAMP/htdocs/progBasi/docente/config-esercizi.php'); //accesso al db di esercizi come $esdb
error_reporting(E_ALL & ~E_NOTICE);//ignoro le notices


try {
    if (isset($_SESSION['table'])) {
        $table = $_SESSION['table'];
        $query = "SELECT * FROM ". $table;
        $stmt = $esdb->prepare($query);
        $stmt->bind_param("s", $table);
        $stmt->execute();
        $result = $stmt->get_result();
        if (!$result) {
            throw new Exception("Esecuzione della query fallita: " . $stmt->error);
        }
        $records = $result->fetch_all(MYSQLI_ASSOC); //salvo in un array tutti i valori salvati come array associativi
        if (empty($records)) {
            throw new Exception("Nessuna record trovato per la tabella: " . $table);
        }
        echo json_encode($records);
    } else {
        throw new Exception("Nessuna tabella specificata nella richiesta.");
    }
} catch (Exception $e) {
    // Gestione degli errori
    header('HTTP/1.1 500 Internal Server Error');
    echo json_encode(['error' => $e->getMessage()]);
}
