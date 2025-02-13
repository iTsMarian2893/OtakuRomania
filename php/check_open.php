<?php
// php/check_open.php

session_start();

if (isset($_SESSION['last_open_timestamp'])) {
    // Intervalul minim între deschideri (în secunde)
    $min_open_interval = 10; // 5 minute

    $lastOpenTimestamp = $_SESSION['last_open_timestamp'];
    $currentTime = time();
    $elapsedTime = $currentTime - $lastOpenTimestamp;

    if ($elapsedTime >= $min_open_interval) {
        // Utilizatorul poate deschide cufărul
        echo 'allowed';
    } else {
        // Nu a trecut suficient timp
        echo 'blocked';
    }
} else {
    // Nu există timestamp, deci nu a deschis încă un cufăr
    echo 'allowed';
}
?>
