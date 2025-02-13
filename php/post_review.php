<?php
session_start();
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verifică dacă utilizatorul este autentificat
    if (!isset($_SESSION['username'])) {
        http_response_code(401); // Unauthorized
        exit("Trebuie să fii autentificat pentru a posta recenzii.");
    }

    // Preia datele din request
    $username = $_SESSION['username'];
    $reviewText = $_POST['reviewText'];
    $pageId = $_POST['pageId']; // Adăugăm această linie pentru a prelua pageId din cererea POST

    // Conectează-te la baza de date (asigură-te să ai detalii corecte pentru conexiune)
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
    $username = $conn->real_escape_string($username);
    $reviewText = $conn->real_escape_string($reviewText);
    $pageId = $conn->real_escape_string($pageId); // Adăugăm această linie pentru a evita SQL injection

    // Inserează recenzia în baza de date
    $sql = "INSERT INTO recenzii (username, review_text, page_id) VALUES ('$username', '$reviewText', '$pageId')";
    $result = $conn->query($sql);

    if ($result) {
        http_response_code(201); // Created
        exit("Recenzia a fost postată cu succes.");
    } else {
        http_response_code(500); // Internal Server Error
        exit("Eroare la postarea recenziei în baza de date: " . $conn->error);
    }

    // Închide conexiunea la baza de date
    $conn->close();
} else {
    http_response_code(405); // Method Not Allowed
    exit("Metoda HTTP nu este permisă.");
}
?>
