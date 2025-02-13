<?php
session_start();

// Conectare la baza de date
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

// Adaugă variabila pageId (setează la id-ul paginii corespunzătoare)
$pageId = "gachiakuta_detalii"; // Setează la id-ul paginii corespunzătoare
$pageId = $conn->real_escape_string($pageId);

// Selectează recenziile din baza de date pentru pagina specificată
$sql = "SELECT username, review_text FROM recenzii WHERE page_id = '$pageId'";
$result = $conn->query($sql);

if ($result) {
    $reviews = array();

    // Construiește un array cu recenziile
    while ($row = $result->fetch_assoc()) {
        $reviews[] = array(
            'username' => $row['username'],
            'reviewText' => $row['review_text']
        );
    }

    // Returnează recenziile sub formă de răspuns JSON
    echo json_encode($reviews);
} else {
    http_response_code(500); // Internal Server Error
    exit("Eroare la extragerea recenziilor: " . $conn->error);
}

// Închide conexiunea la baza de date
$conn->close();
?>
