<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if(!isset($_SESSION['login'])){
    header('Location: ../index.php');
    exit;
}
require ('/Applications/MAMP/htdocs/progBasi/config.php'); //connessione a ESQL as $mysb
error_reporting(E_ALL & ~E_NOTICE);//ignoro le notices


try {
    if (isset($_SESSION['table'])) {
        $table = $_SESSION['table'];
        //echo '<br>tabella su cui cerco attributi: '. $table;
        $query = "SELECT * FROM ATTRIBUTO WHERE nomeTabella = ?";
        $stmt = $mydb->prepare($query);
        $stmt->bind_param("s", $table);
        $stmt->execute();
        $result = $stmt->get_result();
        if (!$result) {
            throw new Exception("Esecuzione della query fallita: " . $stmt->error);
        }
        $attributi = $result->fetch_all(MYSQLI_ASSOC); //salvo in un array tutti i valori salvati come array associativi
        if (empty($attributi)) {
            throw new Exception("Nessuna colonna trovata per la tabella: " . $table);
        }
        //echo json_encode($attributi);
    } else {
        throw new Exception("Nessuna tabella specificata nella richiesta.");
    }
} catch (Exception $e) {
    // Gestione degli errori
    header('HTTP/1.1 500 Internal Server Error');
    echo json_encode(['error' => $e->getMessage()]);
}
?>
