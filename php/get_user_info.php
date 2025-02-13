<?php
session_start();

$servername = "localhost";
$db_username = "root";
$db_password = "";
$dbname = "tesst";

// Creăm conexiunea la baza de date
$conn = new mysqli($servername, $db_username, $db_password, $dbname);

// Verificăm dacă conexiunea a avut succes
if ($conn->connect_error) {
    die("Conexiunea la baza de date a eșuat: " . $conn->connect_error);
}

// Verificăm dacă există o sesiune activă
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];

    // Obținem informații despre utilizator
    $sqlUserInfo = "SELECT u.points, r.rank_name AS rank FROM user_data u LEFT JOIN ranks r ON u.user_rank = r.id WHERE u.username = '$username'";
    $resultUserInfo = $conn->query($sqlUserInfo);

    if (!$resultUserInfo) {
        echo "Eroare la executarea interogării: " . $conn->error;
    } else {
        $userInfo = $resultUserInfo->fetch_assoc();
    
        // Verificăm dacă s-au obținut informațiile cu succes
        if ($userInfo) {
            // Extragem valoarea rangului înainte de a o utiliza
            $userRank = $userInfo['rank'];
            
            // Codificăm rezultatele în format JSON și le returnăm
            echo json_encode($userInfo);
        } else {
            echo json_encode(["points" => 0, "rank" => null]); // Utilizatorul nu are informații
        }
    }
} else {
    echo json_encode(["points" => 0, "rank" => null]); // Nu există o sesiune activă
}

// Închidem conexiunea la baza de date
$conn->close();
?>
