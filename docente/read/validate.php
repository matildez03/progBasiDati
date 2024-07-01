<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Includo la connessione al database
require('/Applications/MAMP/htdocs/progBasi/config.php');

// Se il modulo viene inviato...
if (isset($_POST['login'])) {
// Dati inviati dal modulo
    $email = (isset($_POST['email'])) ? trim($_POST['email']) : ''; // Metto nella variabile 'user' il dato inviato dal modulo
    $pass = (isset($_POST['pass'])) ? trim($_POST['pass']) : ''; // Metto nella variabile 'pass' il dato inviato dal modulo
    //cripto la password
    $pass = md5($pass);
// Controllo se l'utente esiste
    $query1 = "SELECT * FROM UTENTE, DOCENTE WHERE UTENTE.email = DOCENTE.emailUtente AND emailUtente = ? AND password = ? LIMIT 1";
    $utente = $mydb->prepare($query1);
    // Bind dei parametri
    $utente->bind_param('ss', $email, $pass);
    $utente->execute();
    $utente = $utente->get_result();

// Se trova un record
    if (mysqli_num_rows($utente) == 1) {
        //salvo i dati dell'utente in un array
        $login = mysqli_fetch_array($utente);
        // Creo una variabile di sessione contenente i dati dell'utente
        $_SESSION['login'] = array($login['email'], $login['password'], $login['nome'], $login['cognome']);
        echo '<h3>Login effettuato con successo!</h3>';

        //salvataggio dei dati dell'utente
        $query2 = "SELECT * FROM TABELLA WHERE (docente = ?);"; //seleziona tutte le tabelle create da questo docente
        $query3 = "SELECT * FROM TEST WHERE (docente = ?);"; //seleziona tutti i test creati da questo docente

        //ottengo le tabelle
        $qtabelle = $mydb->prepare($query2);
        $qtabelle->bind_param('s', $email);
        $qtabelle->execute();
        $qtabelle = $qtabelle->get_result();

        $qtests = $mydb->prepare($query3);
        $qtests->bind_param('s', $email);
        $qtests->execute();
        $qtests = $qtests->get_result();

        //salvo i risultati nelle variabili di sessione
        $_SESSION['tests'] = array();
        while ($row = mysqli_fetch_assoc($qtests)) {
            $_SESSION['tests'][] = $row;
        }

        $_SESSION['tabelle'] = array();
        while ($row = mysqli_fetch_assoc($qtabelle)) {
            $_SESSION['tabelle'][] = $row;
        }

        // Stampa tutte le tabelle per debug
        foreach ($_SESSION['tabelle'] as $tabella) {
            echo $tabella['nome'] . $tabella['dataCreazione'] . '<br>';
        }

// Rendirizzo l'Utente
        header('Location: ../amministrazione.php');

    } else {
// Se non esiste visualizzo il messaggio di errore
        echo("<h3 style='text-align:center;padding:20px;'>Nome utente o password errati!</h3>");
        header("Refresh:4 url=../");
    }
}




