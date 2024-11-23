<?php
// Fehlerprotokollierung aktivieren (Debugging)
// Zeigt alle PHP-Fehler und -Warnungen an, um Probleme schneller zu identifizieren
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Verbindungsparameter zur Datenbank
$host = 'localhost'; // Der Hostname des Datenbankservers
$dbname = 'vokabeln_db'; // Der Name meiner Datenbank für die Vokabeln
$user = 'root'; // Der Benutzername für die Datenbankverbindung
$pass = ''; // Das leere Passwort für die Verbindung

try {
    // Erstellung der PDO-Datenbankverbindung
    // Die Verbindung erfolgt mit dem Host, der Datenbank, dem Benutzer und dem Passwort
    $mysql = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);


    // Fehlerberichterstattung für PDO aktivieren
    // Dies stellt sicher, dass alle SQL-Fehler als Ausnahmen (Exceptions) geworfen werden
    $mysql->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) { // Wenn ein Fehler auftritt
    // Abbrechen des Skripts und Ausgabe einer Fehlermeldung
    die("Datenbankverbindung fehlgeschlagen: " . $e->getMessage());
}
?>











