<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verifică dacă utilizatorul este autentificat
    if (!isset($_SESSION['username'])) {
        http_response_code(401); // Unauthorized
        exit("Trebuie să fii autentificat pentru a șterge recenzii.");
    }

    // Preia index-ul recenziei de șters
    $index = $_POST['index'];

    // Conectează-te la baza de date
    $servername = "localhost";
    $dbUsername = "root";
    $dbPassword = "";
    $dbName = "recenzii_db";

    $conn = new mysqli($servername, $dbUsername, $dbPassword, $dbName);

    // Verifică conexiunea
    if ($conn->connect_error) {
        http_response_code(500); // Internal Server Error
        exit("Eroare la conectarea la baza de date: " . $conn->connect_error);
    }

    // Escapă caracterele speciale pentru a preveni SQL injection
    $index = $conn->real_escape_string($index);

    // Șterge recenzia din baza de date
    $sql = "DELETE FROM recenzii WHERE id = $index";
    $result = $conn->query($sql);

    if ($result) {
        http_response_code(200); // OK
        exit("Recenzia a fost ștearsă cu succes din baza de date.");
    } else {
        http_response_code(500); // Internal Server Error
        exit("Eroare la ștergerea recenziei: " . $conn->error);
    }

    // Închide conexiunea la baza de date
    $conn->close();
} else {
    http_response_code(405); // Method Not Allowed
    exit("Metoda HTTP nu este permisă.");
}
?>
