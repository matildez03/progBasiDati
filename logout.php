<?php
session_start();
session_destroy();
session_abort();
header("Location: index.php");
// Imposta le intestazioni per evitare la cache
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
?>
