<?php
session_start();

// Verifică dacă utilizatorul este autentificat
if (isset($_SESSION['user_id'])) {
    // Conectare la baza de date (actualizează cu informațiile tale de conectare)
    $servername = "localhost";
    $dbUsername = "root";
    $dbPassword = "";
    $dbName = "tesst";

    $conn = new mysqli($servername, $dbUsername, $dbPassword, $dbName);

    // Verifică dacă conexiunea la baza de date a avut succes
    if ($conn->connect_error) {
        die("Conexiunea la baza de date a eșuat: " . $conn->connect_error);
    }

    $userId = $_SESSION['user_id'];
    $itemId = $_POST['itemId'];
    $itemCost = $_POST['itemCost'];

    // Obține punctele utilizatorului
    $sqlPoints = "SELECT points FROM user_data WHERE user_id = $userId";
    $resultPoints = $conn->query($sqlPoints);

    if ($resultPoints->num_rows > 0) {
        $rowPoints = $resultPoints->fetch_assoc();
        $userPoints = $rowPoints['points'];

        // Verifică dacă utilizatorul are suficiente puncte pentru a cumpăra
        if ($userPoints >= $itemCost) {
            // Actualizează punctele utilizatorului
            $newPoints = $userPoints - $itemCost;
            $sqlUpdatePoints = "UPDATE user_data SET points = $newPoints WHERE user_id = $userId";
            $conn->query($sqlUpdatePoints);

            // Răspunde cu succes
            echo json_encode(['success' => true]);
        } else {
            // Răspunde cu eroare
            echo json_encode(['error' => 'Not enough points']);
        }
    } else {
        // Răspunde cu eroare
        echo json_encode(['error' => 'User not found']);
    }

    // Închide conexiunea la baza de date
    $conn->close();
} else {
    // Răspunde cu eroare
    echo json_encode(['error' => 'User not authenticated']);
}
?>
