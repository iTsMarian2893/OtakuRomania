<?php
// buy_rank.php

session_start();

if (isset($_SESSION['username']) && isset($_POST['rank_id'])) {
    $username = $_SESSION['username'];
    $rankId = $_POST['rank_id'];

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

    // Obține informații despre rang din baza de date
    $sqlRankInfo = "SELECT rank_name, price FROM ranks WHERE id = $rankId";
    $resultRankInfo = $conn->query($sqlRankInfo);

    // Verifică dacă s-a obținut cu succes informațiile despre rang
    if ($resultRankInfo !== false && $resultRankInfo->num_rows > 0) {
        $rowRankInfo = $resultRankInfo->fetch_assoc();
        $rankName = $rowRankInfo['rank_name'];
        $rankPrice = $rowRankInfo['price'];

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

                // Verifică dacă utilizatorul are suficiente puncte pentru a cumpăra rangul
                if ($userPoints >= $rankPrice) {
                    // Actualizează punctele utilizatorului și adaugă rangul în baza de date
                    $newPoints = $userPoints - $rankPrice;
                    $sqlUpdatePoints = "UPDATE user_data SET points = $newPoints WHERE user_id = $userId";
                    $sqlAddRank = "UPDATE user_data SET user_rank = '$rankName' WHERE user_id = $userId";

                    if ($conn->query($sqlUpdatePoints) === TRUE && $conn->query($sqlAddRank) === TRUE) {
                        echo "success";
                    } else {
                        echo "Eroare la actualizarea punctelor și rangului în baza de date: " . $conn->error;
                    }
                } else {
                    echo "Nu ai suficiente puncte pentru a cumpăra acest rang.";
                }
            } else {
                echo "Eroare la obținerea punctelor din baza de date.";
            }
        } else {
            echo "Eroare la obținerea user_id-ului din baza de date.";
        }
    } else {
        echo "Eroare la obținerea informațiilor despre rang din baza de date.";
    }

    // Închide conexiunea la baza de date
    $conn->close();
} else {
    echo "Eroare la cumpărarea rangului.";
}
?>
