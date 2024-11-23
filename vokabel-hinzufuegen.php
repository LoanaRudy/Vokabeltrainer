<?php
// Startet die Session, um auf Session-Variablen wie den Benutzernamen zugreifen zu können
session_start(); 

// Aktiviert die Anzeige aller Fehler und Warnungen zur leichteren Fehlerbehebung (Debugging)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Überprüft, ob der Benutzer eingeloggt ist, indem geprüft wird, ob die Session-Variable "username" gesetzt ist
if (!isset($_SESSION["username"])) {
    // Wenn der Benutzer nicht eingeloggt ist, wird er zur Login-Seite weitergeleitet
    header("Location: index.php");
    exit;
}

// Bindet die Datei ein, die die Verbindung zur Datenbank herstellt
require_once('mysql-vokabel.php');

// Initialisiert die Nachricht, die als Feedback angezeigt wird
$message = "";

// Überprüft, ob das Formular durch Drücken des Buttons "Vokabel hinzufügen" abgeschickt wurde
if (isset($_POST['submit'])) {
    // Holt die Benutzereingaben aus dem Formular und entfernt Leerzeichen am Anfang und Ende
    $deutsches_wort = trim($_POST['deutsches_wort']);
    $englisches_wort = trim($_POST['englisches_wort']);

    // Überprüft, ob beide Eingabefelder ausgefüllt wurden
    if (!empty($deutsches_wort) && !empty($englisches_wort)) {
        try {
            // Bereitet eine SQL-Anweisung vor, um die eingegebene Vokabel in die Datenbank einzufügen
            $stmt = $mysql->prepare("INSERT INTO Vokabeln (deutsches_Wort, englisches_Wort) VALUES (:deutsch, :englisch)");
            // Führt die SQL-Anweisung aus und ersetzt die Platzhalter durch die eingegebenen Werte
            $stmt->execute([
                ':deutsch' => $deutsches_wort, // Wert für das Feld "deutsches_Wort"
                ':englisch' => $englisches_wort // Wert für das Feld "englisches_Wort"
            ]);

            // Erfolgsnachricht, die bei erfolgreichem Hinzufügen der Vokabel gesetzt wird
            $message = "Vokabel erfolgreich hinzugefügt!";
        } catch (PDOException $e) {
            // Fehlernachricht, falls ein Problem bei der Datenbankabfrage auftritt
            $message = "Fehler beim Hinzufügen der Vokabel: " . $e->getMessage();
        }
    } else {
        // Warnmeldung, falls eines der Eingabefelder leer ist
        $message = "Bitte füllen Sie beide Felder aus.";
    }
}
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vokabel Hinzufügen</title>
    <!-- CSS Bootstrap Einbindung -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="vokabel-hinzufuegen.css">
</head>
<body>

<!-- Hauptcontainer für das Formular -->
<div class="container">
    <div class="form-container">
        <h2>Neue Vokabel hinzufügen</h2>

        <!-- Formular für die Benutzereingaben -->
        <form method="POST" action="vokabel-hinzufuegen.php">
            <!-- Eingabefeld für das deutsche Wort -->
            <div class="mb-3">
                <label for="deutsches_wort" class="form-label">Deutsches Wort</label>
                <input type="text" class="form-control" id="deutsches_wort" name="deutsches_wort" required>
            </div>

            <!-- Eingabefeld für das englische Wort -->
            <div class="mb-3">
                <label for="englisches_wort" class="form-label">Englisches Wort</label>
                <input type="text" class="form-control" id="englisches_wort" name="englisches_wort" required>
            </div>

            <!-- Erfolgs- oder Fehlermeldung anzeigen, falls eine Nachricht gesetzt ist -->
            <?php if (!empty($message)): ?>
                <div class="alert alert-success mt-3">
                    <!-- Dynamische Ausgabe der Nachricht -->
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>

            <!-- Container für die Buttons -->
            <div class="button-container mt-3">
                <!-- Button zum Absenden des Formulars -->
                <button type="submit" name="submit" class="btn btn-lila">Vokabel hinzufügen</button>
                <!-- Link zurück zur Startseite -->
                <a href="startseite.php" class="btn btn-secondary">Zurück zur Startseite</a>
            </div>
        </form>
    </div>
</div>

</body>
</html>
