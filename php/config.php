<?php

// Configurări pentru conexiunea la baza de date
$servername = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbName = "recenzii_db";

// Crează conexiunea la baza de date
$conn = new mysqli($servername, $dbUsername, $dbPassword, $dbName);

// Verifică conexiunea
if ($conn->connect_error) {
    die("Eroare la conectarea la baza de date: " . $conn->connect_error);
}

?>
