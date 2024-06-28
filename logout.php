<?php
session_destroy();
session_abort();
header("Location: index.php");
?>
