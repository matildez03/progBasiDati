<?php
// funzione per eseguire la query select di tutti i test eseguiti dallo studente

require('/Applications/MAMP/htdocs/progBasi/config.php'); //includo la connessione al db
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
error_reporting(E_ALL & ~E_NOTICE);//ignoro le notices
$tests = '';
// creo la query
$query="SELECT * FROM TEST;";
$res = $mydb->query($query);
$tests = mysqli_fetch_all($res); //salvo tutte le righe risultanti in un array Associativo
$testConclusi = null;
$testInCompletamento = null;

//recupero i test avviati dello studente

if(isset($_SESSION['login'])){

    $studente = $_SESSION['login'][0]; //email dello studente che ha effettuato l'accesso

    //query per selezionare tutti i testi conclusi dallo studente
    $stato = 'concluso';
    $query1= "SELECT * FROM TESTAVVIATO WHERE studente = ? AND stato= ?;";
    $stmt = $mydb->prepare($query1);
    if ($stmt === false) {
        throw new Exception("Errore nella preparazione della query: " . $mydb->error);
    }
    $stmt->bind_param('ss', $studente, $stato);
    if($stmt->execute()){
        $res1 = $stmt->get_result();
        $testConclusi = mysqli_fetch_all($res1);
    } $stmt->close();

    //query per selezionare tutti i test che lo studente ha lasciato in completamento
    $stato = 'inCompletamento';
    $query2 = "SELECT * FROM TESTAVVIATO WHERE studente = ? AND stato= ? ;";
    $stmt = $mydb->prepare($query2);
    if ($stmt === false) {
        throw new Exception("Errore nella preparazione della query: " . $mydb->error);
    }
    $stmt->bind_param('ss', $studente, $stato);
    if($stmt->execute()){
        $res2 = $stmt->get_result();
        $testInCompletamento = mysqli_fetch_all($res2);
    }

    $query3 = "CALL Elenco_Nuovi_Test(?)";//query per selezionare tuti i test che lo studente non ha ancora iniziato e che sono disponibili
    $stmt = $mydb->prepare($query3);
    if ($stmt === false) {
        throw new Exception("Errore nella preparazione della query: " . $mydb->error);
    }
    $stmt->bind_param('s', $studente);
    if($stmt->execute()){
        $res3 = $stmt->get_result();
        $tests = mysqli_fetch_all($res3); //sovrascrivo la variabile dei test disponibili con quelli che non sono conclusi o in completamento
    }
    //echo ('<br>test disponibili:' . json_encode($tests));


}

