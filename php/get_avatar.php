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

    // Obține calea avatarului din baza de date pentru utilizatorul curent
    $sqlAvatar = "SELECT avatar_path FROM user_data WHERE user_id = $userId";
    $resultAvatar = $conn->query($sqlAvatar);

    if ($resultAvatar) {
        // Verifică dacă există un rând în rezultat
        if ($resultAvatar->num_rows > 0) {
            $rowAvatar = $resultAvatar->fetch_assoc();
            $avatarPath = !empty($rowAvatar['avatar_path']) ? $rowAvatar['avatar_path'] : "/poze/kirito_avatar.png";
        } else {
            // Dacă nu există niciun rând, utilizează avatarul implicit
            $avatarPath = "/poze/kirito_avatar.png";
        }

        // Întoarce calea avatarului ca răspuns la solicitarea Ajax
        echo json_encode(['avatarPath' => $avatarPath]);
    } else {
        // Eroare la interogare
        echo json_encode(['error' => "Eroare la obținerea avatarului: " . $conn->error]);
    }

    // Închide conexiunea la baza de date
    $conn->close();
} else {
    // Dacă utilizatorul nu este autentificat, întoarce calea către avatarul implicit
    $avatarPath = "/poze/kirito_avatar.png";
    echo json_encode(['avatarPath' => $avatarPath]);
}




?>
