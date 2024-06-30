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
    $insert1 = "INSERT INTO UTENTE (email, password, nome, cognome) VALUES (?,?,?,?)";
    $res = $mydb->prepare($insert1);
    $res->bind_param('ssss', $email, $password, $nome, $cognome);

    $insert2 = "INSERT INTO STUDENTE (emailUtente, matricola, anno) VALUES (?,?,?)";
    $res2 = $mydb->prepare($insert2);
    $res2->bind_param('sss', $email, $matricola, $anno);

    if ($res->execute()) {
        if ($res2->execute()) {
            echo('registrazione avvenuta con successo');
            header('Location: ../../index.php');
        }
    }
} else {
    echo('le password non corrispondono');
}
