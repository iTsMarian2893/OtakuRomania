<?php
// php/update_timestamp.php

session_start();

// Setăm timestamp-ul ultimei deschideri la timpul curent
$_SESSION['last_open_timestamp'] = time();

echo 'Timestamp actualizat cu succes.';
?>
