<?php
// Fehlerprotokollierung aktivieren
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Verbindungsparameter zur Datenbank
$host = 'localhost';
$dbname = 'vokabeln_db';  // Der genaue Name der Datenbank
$user = 'root';  // MySQL-Benutzername (standardmäßig root bei XAMPP)
$pass = '';  // MySQL-Passwort (standardmäßig leer bei XAMPP)

try {
    // PDO-Datenbankverbindung
    $mysql = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $mysql->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Datenbankverbindung fehlgeschlagen: " . $e->getMessage());
}
?>










