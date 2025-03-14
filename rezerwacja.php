<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "egzaminac";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $Date = trim($_POST["Data"]);
    $Osoby = trim($_POST["Osoby"]);
    $Phone = trim($_POST["Phone"]);

    if (!empty($Date) && !empty($Osoby) && !empty($Phone)) {
        if (!preg_match("/^[0-9]{9}$/", $Phone)) {
            $message = "Błąd: Nieprawidłowy numer telefonu!";
        } else {
            $stmt = $conn->prepare("INSERT INTO rezerwacje (data_rez, liczba_osob, telefon) VALUES (?, ?, ?)");
            $stmt->bind_param("sis", $Date, $Osoby, $Phone);

            if ($stmt->execute()) {
                $message = "Rezerwacja udana!";
            } else {
                $message = "Błąd: " . $stmt->error;
            }

            $stmt->close();
        }
    } else {
        $message = "Wszystkie pola muszą być wypełnione!";
    }
}

$conn->close();
echo $message;
?>
