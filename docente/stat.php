<?php
session_start();
require('config.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistiche</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center">Statistiche</h2>

    <!-- Classifica degli studenti per numero di test completati -->
    <div class="card my-4">
        <div class="card-header">
            Classifica Studenti - Test Completati
        </div>
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Posizione</th>
                    <th>Codice Studente</th>
                    <th>Numero di Test Completati</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $sql = "SELECT codice_studente, test_completati FROM classifica_test_completati";
                $result = $mydb->query($sql);
                if ($result->num_rows > 0) {
                    $posizione = 1;
                    while($row = $result->fetch_assoc()) {
                        echo "<tr><td>" . $posizione . "</td><td>" . $row['codice_studente'] . "</td><td>" . $row['test_completati'] . "</td></tr>";
                        $posizione++;
                    }
                } else {
                    echo "<tr><td colspan='3'>Nessun dato disponibile</td></tr>";
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Classifica degli studenti per numero di risposte corrette -->
    <div class="card my-4">
        <div class="card-header">
            Classifica Studenti - Risposte Corrette
        </div>
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Posizione</th>
                    <th>Codice Studente</th>
                    <th>Risposte Corrette</th>
                    <th>Risposte Totali</th>
                    <th>Percentuale Corrette</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $sql = "SELECT codice_studente, risposte_corrette, risposte_totali, 
                        ROUND((risposte_corrette / risposte_totali) * 100, 2) AS percentuale_corrette 
                        FROM classifica_risposte_corrette";
                $result = $mydb->query($sql);
                if ($result->num_rows > 0) {
                    $posizione = 1;
                    while($row = $result->fetch_assoc()) {
                        echo "<tr><td>" . $posizione . "</td><td>" . $row['codice_studente'] . "</td><td>" . $row['risposte_corrette'] . "</td><td>" . $row['risposte_totali'] . "</td><td>" . $row['percentuale_corrette'] . "%</td></tr>";
                        $posizione++;
                    }
                } else {
                    echo "<tr><td colspan='5'>Nessun dato disponibile</td></tr>";
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Classifica dei quesiti per numero di risposte -->
    <div class="card my-4">
        <div class="card-header">
            Classifica Quesiti - Numero di Risposte
        </div>
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Posizione</th>
                    <th>ID Quesito</th>
                    <th>Numero di Risposte</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $sql = "SELECT numero_quesito, numero_risposte_inserite FROM classifica_quesiti";
                $result = $mydb->query($sql);
                if ($result->num_rows > 0) {
                    $posizione = 1;
                    while($row = $result->fetch_assoc()) {
                        echo "<tr><td>" . $posizione . "</td><td>" . $row['numero_quesito'] . "</td><td>" . $row['numero_risposte_inserite'] . "</td></tr>";
                        $posizione++;
                    }
                } else {
                    echo "<tr><td colspan='3'>Nessun dato disponibile</td></tr>";
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

</body>
</html>