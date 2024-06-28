<?php
require('../validate.php');
if(!isset($_SESSION['login'])){
    header('Location: ../index.php');
    exit;
}
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

//ottengo le variabili mandate in post
$tab = $_POST['tabella'];
$chiavi = $_POST['chiave'];
$chiave = implode(', ', $chiavi); //creo una stringa con le chiavi separate da virgole

// Verifica se esiste una chiave primaria sulla tabella
$query_check = "SHOW KEYS FROM $tab WHERE Key_name = 'PRIMARY'";
$result_check = $mydb->query($query_check);

if ($result_check->num_rows > 0) {
    // Se esiste una chiave primaria, procedi a rimuoverla
    $query_remove = "ALTER TABLE $tab DROP PRIMARY KEY";
    $mydb->query($query_remove);


    if ($mydb->errno) {
        echo "Errore durante la rimozione della chiave primaria: " . $mydb->error;
    } else {
        echo "Chiave primaria rimossa con successo";
        $query_update = "UPDATE ATTRIBUTO SET isChiave = 0";
        $mydb->query($query_update);
    }
} else {
    echo "Nessuna chiave primaria trovata nella tabella";
}

//creo la query di inserimento della chiave
$query1 = "ALTER TABLE $tab ADD PRIMARY KEY ($chiave)";
$res = $mydb->query($query1);
if($res){
    echo 'operazione riuscita';
    foreach($chiavi as $k) {
        $query2 = "UPDATE ATTRIBUTO SET isChiave = 1 WHERE nome = '$k'";
        $mydb->query($query2);
    }
}


?>
