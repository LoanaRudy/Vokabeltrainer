<?php
$host = "localhost";  // Datenbank-Host
$name = "vokabeln_db";  // Name der Datenbank
$user = "root";  // Benutzername für MySQL
$passwort = "";  // Passwort für MySQL

try {
    // Verbindung zur Datenbank herstellen
    $mysql = new PDO("mysql:host=$host;dbname=$name;charset=utf8", $user, $passwort);
    $mysql->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  // Fehlerbehandlung aktivieren
} catch (PDOException $e) {
    // Fehlerbehandlung, falls die Verbindung fehlschlägt
    die("Verbindungsfehler: " . $e->getMessage());
}
?>


