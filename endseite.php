<?php
// Starten der PHP-Session
session_start();

// Überprüfen, ob der Test überhaupt abgeschlossen wurde
if (!isset($_SESSION['test_started'])) {
    // Wenn der Test nicht gestartet wurde, leite zur Startseite weiter
    header("Location: startseite.php");
    exit();
}

// Testdaten (Punktestand und Gesamtfragenanzahl) auslesen
$score = $_SESSION['score']; // Erzielte Punktzahl
$total_questions = count($_SESSION['vokabeln']); // Gesamtanzahl der Fragen

// Session-Daten bereinigen, um den Teststatus zurückzusetzen
unset($_SESSION['test_started']); // Teststatus löschen
unset($_SESSION['vokabeln']); // Vokabeln aus der Session löschen
unset($_SESSION['current_question']); // Aktuelle Frage zurücksetzen
unset($_SESSION['score']); // Punktestand zurücksetzen
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <!-- Meta-Daten für den Zeichensatz und die responsive Darstellung -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Seitentitel -->
    <title>Test abgeschlossen</title>
    
    <!-- Bootstrap CSS für das Styling -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="endseite.css"> <!-- Eigene CSS-Datei für individuelles Styling -->
</head>
<body class="bg-light"> <!-- Heller Hintergrund -->

<div class="container">
    <div class="form-container">
        <!-- Glückwunsch-Nachricht -->
        <h1>Herzlichen Glückwunsch!</h1>
        <p>Du hast den Test beendet.</p>

        <!-- Punktestand anzeigen -->
        <h2>Deine Punktzahl:</h2>
        <p><?php echo $score; ?> von <?php echo $total_questions; ?></p>

        <!-- Buttons: Zurück zur Startseite und Test wiederholen -->
        <div class="button-container">
            <!-- Button zur Startseite -->
            <form method="POST" action="startseite.php">
                <button type="submit" class="btn btn-lila">Zurück zur Startseite</button>
            </form>

            <!-- Button zum Test wiederholen -->
            <form method="POST" action="test.php">
                <!-- Verstecktes Inputfeld, um den Test neu zu starten -->
                <input type="hidden" name="restart_test" value="1">
                <button type="submit" class="btn btn-lila">Test wiederholen</button>
            </form>
        </div>
    </div>
</div>

</body>
</html>
