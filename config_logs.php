<?php
$mongoClient = new MongoDB\Client("mongodb://localhost:27017");
$loggingDb = $mongoClient->loggingdb;
$logsCollection = $loggingDb->logs;
?>
