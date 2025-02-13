<?php
// actualizare_puncte.php

session_start();

// Verifică dacă utilizatorul este autentificat
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];

    $servername = "localhost";
    $db_username = "root";
    $db_password = "";
    $dbname = "tesst";

    // Crează conexiunea la baza de date
    $conn = new mysqli($servername, $db_username, $db_password, $dbname);

    // Verifică dacă conexiunea a avut succes
    if ($conn->connect_error) {
        die("Conexiunea la baza de date a eșuat: " . $conn->connect_error);
    }

    // Obține user_id-ul pentru utilizatorul curent
    $sqlUserId = "SELECT id FROM users WHERE username = '$username'";
    $resultUserId = $conn->query($sqlUserId);

    // Verifică dacă s-a obținut cu succes user_id-ul
    if ($resultUserId->num_rows > 0) {
        $rowUserId = $resultUserId->fetch_assoc();
        $userId = $rowUserId['id'];

        // Obține punctele actuale ale utilizatorului
        $sqlPoints = "SELECT points FROM user_data WHERE user_id = $userId";
        $resultPoints = $conn->query($sqlPoints);

        if ($resultPoints->num_rows > 0) {
            $rowPoints = $resultPoints->fetch_assoc();
            $userPoints = $rowPoints['points'];

            // Actualizează punctele (adăugăm 50 de puncte)
            $newPoints = $userPoints + 50;

            $sqlUpdatePoints = "UPDATE user_data SET points = $newPoints WHERE user_id = $userId";

            if ($conn->query($sqlUpdatePoints) === TRUE) {
                // Returnează un răspuns JSON pentru a fi procesat de JavaScript
                echo json_encode(array('success' => true, 'message' => 'Punctele au fost actualizate cu succes!'));
            } else {
                // Returnează un răspuns JSON pentru a fi procesat de JavaScript
                echo json_encode(array('success' => false, 'message' => 'Eroare la actualizarea punctelor în baza de date: ' . $conn->error));
            }
        } else {
            // Returnează un răspuns JSON pentru a fi procesat de JavaScript
            echo json_encode(array('success' => false, 'message' => 'Eroare la obținerea punctelor din baza de date.'));
        }
    } else {
        // Returnează un răspuns JSON pentru a fi procesat de JavaScript
        echo json_encode(array('success' => false, 'message' => 'Eroare la obținerea user_id-ului din baza de date.'));
    }

    // Închide conexiunea la baza de date
    $conn->close();
} else {
    // Returnează un răspuns JSON pentru a fi procesat de JavaScript
    echo json_encode(array('success' => false, 'message' => 'Eroare la actualizarea punctelor. Utilizatorul nu este autentificat.'));
}
?>
