<?php
require('../../config.php');

//recupero i dati mandati in post
$nome = $_POST['nome'];
$cognome = $_POST['cognome'];
$email = $_POST['email'];
$pass = $_POST['pass'];
$pass2 = $_POST['pass2'];
$anno = $_POST['anno'];
$matricola = $_POST['matricola'];


//controllo che le password siano uguali
if ($pass == $pass2) {
    //registro il docente
    $password = md5($pass); //hasho la password in md5

    $query = "CALL registra_studente(?,?,?,?,?,?);";
    $res = $mydb->prepare($query);
    $res->bind_param('sssssi', $nome, $cognome, $email, $password, $matricola, $anno);
    if ($res->execute()) {
        echo('registrazione avvenuta con successo');
        header('Location: ../../index.php');
    }
} else {
    echo('le password non corrispondono');
}
