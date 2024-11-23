<?php
// Datenbankverbindungsdetails festlegen
$host = "localhost"; // Der Hostname des Datenbankservers, üblicherweise "localhost"
$name = "test"; // Der Name der zu verwendenden Datenbank
$user = "root"; // Der Benutzername für die Datenbankverbindung
$passwort = ""; // Das Passwort für die Datenbankverbindung (bei XAMPP oft leer)

// Versuch, eine Verbindung zur Datenbank herzustellen
try {
    // Erstellen eines PDO-Objekts für die Verbindung
    // Es wird der Host, der Datenbankname, der Benutzername und das Passwort übergeben
    $mysql = new PDO("mysql:host=$host;dbname=$name", $user, $passwort);


    // Wenn die Verbindung erfolgreich ist, passiert hier nichts weiter
} catch (PDOException $e) { // Falls ein Fehler auftritt
    // Fehlermeldung ausgeben, wenn die Verbindung fehlschlägt
    echo "SQL Error: " . $e->getMessage();
    // Der Fehler wird mit einer Nachricht angezeigt, die die Ursache beschreibt
}
?>
