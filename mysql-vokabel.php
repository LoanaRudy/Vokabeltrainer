<?php
$host = "localhost";
$name = "vokabeln_db";
$user = "root";
$passwort = "";

try {
    $mysql = new PDO("mysql:host=$host;dbname=$name", $user, $passwort);
    $mysql->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Verbindungsfehler: " . $e->getMessage();
    exit();
}
?>



