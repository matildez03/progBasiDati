<?php
require('../../config.php');
/*
 * per potersi registrare il docente deve conoscere i dati di accesso al database
 * username = root
 * password = root
 */
//recupero i dati mandati in post

$usdb = $_POST['usdb'];
$pwdb = $_POST['pwdb'];
$nome = $_POST['nome'];
$cognome = $_POST['cognome'];
$email = $_POST['email'];
$pass = $_POST['pass'];
$pass2 = $_POST['pass2'];
$dip = $_POST['dipartimento'];
$corso = $_POST['corso'];

//controllo che il docente abbia immesso i dati corretti
if($pwdb=='root' && $usdb =='root'){
    //controllo che le password siano uguali
    if($pass==$pass2) {
        //registro il docente
        $password = md5($pass); //hasho la password in md5
        $query = "CALL registra_docente(?,?,?,?,?,?);";
        $res = $mydb->prepare($query);
        $res->bind_param('ssssss', $nome, $cognome, $email, $password, $dip, $corso);
        if ($res->execute()) {
            echo('registrazione avvenuta con successo');
            header('Location: ../../index.php');
        }
    } else{
        echo ('le password non corrispondono');
    }
} else{
    echo "credenziali errate.";
}
