<?php
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: index.php");
    exit;
}

// Datenbankverbindung einbinden
require_once('mysql-vokabel.php');

// Eine zufällige Vokabel aus der Datenbank abrufen
if (!isset($_SESSION['vokabel'])) {
    $stmt = $mysql->query("SELECT * FROM Vokabeln ORDER BY RAND() LIMIT 1");
    $vokabel = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // Vokabel in der Session speichern, damit die gleiche Vokabel bei der Antwort überprüft wird
    $_SESSION['vokabel'] = $vokabel;
}

$vokabel = $_SESSION['vokabel'];
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Vokabeltest</title>
</head>
<body>
    <h1>Vokabeltest</h1>

    <!-- Aufgabenstellung -->
    <p>Übersetze folgendes Wort ins Englische:</p>
    <h3><?php echo htmlspecialchars($vokabel['deutsches_Wort']); // Zeige die deutsche Vokabel an ?></h3>

    <!-- Formular für die Eingabe der Übersetzung -->
    <form method="POST" action="ergebnis.php">
        <label for="antwort">Deine Übersetzung:</label>
        <input type="text" name="antwort" id="antwort" required>
        <button type="submit">Antwort einreichen</button>
    </form>

    <!-- Button für Test abbrechen -->
    <form method="POST" action="startseite.php">
        <button type="submit" name="abbrechen">Test abbrechen</button>
    </form>
</body>
</html>

