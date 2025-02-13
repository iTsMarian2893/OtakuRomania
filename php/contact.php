<?php
// Conectare la baza de date (înlocuiește cu informațiile tale)
$servername = "localhost";
$db_username = "root";
$password = "";
$dbname = "contact";

$conn = new mysqli($servername, $db_username, $password, $dbname);

// Verifică conexiunea
if ($conn->connect_error) {
    die("Conexiunea la baza de date a eșuat: " . $conn->connect_error);
}

// Obține datele din formular
$username = $_POST['username'];
$email = $_POST['email'];
$message = $_POST['message'];

// Inserează datele în baza de date
$sql = "INSERT INTO contact (username, email, message) VALUES ('$username', '$email', '$message')";


// Inserează datele în baza de date
if ($conn->query($sql) === TRUE) {
    echo "";
} else {
    echo "Eroare: " . $sql . "<br>" . $conn->error;
}

// Închide conexiunea la baza de date
$conn->close();
?>
<!DOCTYPE html>
<html >
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mulțumim!</title>
    <style>
        body {
            background-image: url('../poze/bg_blurat.jpg');
    background-size: cover;
    background-attachment: fixed;
    background-position: center;
    background-repeat: no-repeat;
            font-family: Arial, sans-serif;
            color: #fff;
            text-align: center;
            padding: 100px;
            margin: 0;
        }

        .container {
            background-color: rgb(48 47 47 / 50%)/* Fundal semi-transparent */
            padding: 20px;
            border-radius: 10px;
        }

        h1, p {
            margin-bottom: 20px;
        }

        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Mulțumim pentru mesaj!</h1>
        <p>Vă vom contacta în curând.</p>
        <a href="../main.php"><button>Înapoi la Pagina Principală</button></a>
    </div>
</body>
</html>
