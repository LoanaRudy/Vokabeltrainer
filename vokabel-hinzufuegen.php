<?php
// Startet die Session, um Benutzerdaten während der Sitzung verfügbar zu machen
session_start(); 

// Aktiviert die Fehlerprotokollierung, damit du Fehler und Warnungen während der Entwicklung siehst
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Überprüft, ob der Benutzer eingeloggt ist, indem geprüft wird, ob die Session-Variable "username" gesetzt ist
if (!isset($_SESSION["username"])) {
    // Wenn nicht eingeloggt, wird der Benutzer zur Login-Seite weitergeleitet
    header("Location: index.php");
    exit;
}

// Überprüft, ob das Formular zum Hinzufügen einer Vokabel abgeschickt wurde
if (isset($_POST['submit'])) {
    // Bindet die Datei zur Datenbankverbindung ein
    require_once('mysql-vokabel.php');

    // Holt die eingegebenen Wörter aus dem Formular
    $deutsches_wort = $_POST['deutsches_wort'];
    $englisches_wort = $_POST['englisches_wort'];

    // Überprüft, ob beide Eingabefelder nicht leer sind
    if (!empty($deutsches_wort) && !empty($englisches_wort)) {
        // Bereitet einen SQL-Befehl vor, um die neuen Vokabeln in die Datenbank einzufügen
        $stmt = $mysql->prepare("INSERT INTO Vokabeln (deutsches_Wort, englisches_Wort) VALUES (:deutsch, :englisch)");
        
        // Führt den SQL-Befehl mit den eingegebenen Daten aus
        $stmt->execute([
            ':deutsch' => $deutsches_wort, // Platzhalter für das deutsche Wort
            ':englisch' => $englisches_wort // Platzhalter für das englische Wort
        ]);

        // Setzt eine Erfolgsnachricht, die auf der Seite angezeigt wird
        $message = "Vokabel erfolgreich hinzugefügt!";
        $message_class = "alert-success"; // CSS-Klasse für Erfolg
    } else {
        // Setzt eine Fehlermeldung, wenn die Felder nicht ausgefüllt wurden
        $message = "Bitte beide Felder ausfüllen!";
        $message_class = "alert-danger"; // CSS-Klasse für Fehler
    }
}
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vokabel Hinzufügen</title>
    <!-- Bootstrap für allgemeines Styling einbinden -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Eigene CSS-Datei für individuelles Styling -->
    <link rel="stylesheet" href="vokabel-hinzufuegen.css">
</head>
<body>

<div class="container">
    <div class="form-container">
        <!-- Überschrift der Seite -->
        <h2>Neue Vokabel hinzufügen</h2>

        <!-- Zeigt eine Nachricht an, wenn sie gesetzt wurde (Erfolg oder Fehler) -->
        <?php if (isset($message)): ?>
            <div class="alert <?php echo $message_class; ?>">
                <!-- Dynamisch generierter Nachrichtentext -->
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <!-- Formular zum Hinzufügen einer neuen Vokabel -->
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

            <!-- Buttons für die Aktionen (Hinzufügen und Zurück zur Startseite) -->
            <div class="button-container">
                <!-- Senden-Button für das Formular -->
                <button type="submit" name="submit" class="btn btn-lila">Vokabel hinzufügen</button>
                <!-- Link zurück zur Startseite -->
                <a href="startseite.php" class="btn btn-secondary">Zurück zur Startseite</a>
            </div>
        </form>
    </div>
</div>

</body>
</html>






