<?php
//recupera i dati in post del form del test
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
// Verifica se lo studente è in sessione
if (!isset($_SESSION['login'][0])) {
    header('Location: ../../index.php');
    exit;
}
require('/Applications/MAMP/htdocs/progBasi/config.php');

// Recupera il numero di telefono inviato tramite POST
if (isset($_POST['telefono'])) {
    $telefono = $_POST['telefono'];
    // Recupera lo studente dalla sessione
    $emailUtente = $_SESSION['login'][0];

    echo $telefono;
    // Esegui la query per aggiornare il numero di telefono dello studente
    $query = "INSERT INTO TELEFONO (emailUtente, recapito ) VALUES (?,?)";
    $stmt = $mydb->prepare($query);
    $stmt->bind_param("ss", $emailUtente, $telefono);

    if ($stmt->execute()) {
        echo "Numero di telefono aggiornato correttamente.";
    } else {
        echo "Errore nell'aggiornamento del numero di telefono: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "Errore: Numero di telefono non ricevuto dal form.";
}
?>