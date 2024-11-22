<?php
// Session starten, um Benutzerinformationen und den Status des Tests zu speichern
session_start();

// Überprüfen, ob der Benutzer eingeloggt ist. Falls nicht, zur Login-Seite weiterleiten
if (!isset($_SESSION["username"])) {
    header("Location: index.php");
    exit;
}

// Verbindung zur Datenbank herstellen, um auf die Vokabeln zuzugreifen
require_once('mysql-vokabel.php');

// Überprüfen, ob der Test gestartet wurde
if (!isset($_SESSION['test_started'])) {
    // Alle Vokabeln aus der Datenbank abrufen
    $stmt = $mysql->query("SELECT * FROM Vokabeln");
    $_SESSION['vokabeln'] = $stmt->fetchAll(PDO::FETCH_ASSOC); // Speichert die Vokabeln in der Session
    $_SESSION['test_started'] = true; // Markiert den Test als gestartet
    $_SESSION['current_question'] = 0; // Setzt die erste Frage
    $_SESSION['score'] = 0; // Initialisiert den Punktestand
}

// Überprüfen, ob der Benutzer den Test abbrechen möchte
if (isset($_POST['cancel_test'])) {
    unset($_SESSION['test_started']); // Teststatus zurücksetzen
    header("Location: startseite.php"); // Zurück zur Startseite
    exit();
}

// Überprüfen, ob der Benutzer eine Antwort eingereicht hat
if (isset($_POST['submit_answer'])) {
    // Eingabe und korrekte Antwort bereinigen
    $user_answer = trim($_POST['user_answer']); // Eingabe des Benutzers
    $correct_answer = trim($_SESSION['vokabeln'][$_SESSION['current_question']]['englisches_Wort']); // Richtige Antwort

    // Überprüfen, ob die Antwort korrekt ist
    if (strcasecmp($user_answer, $correct_answer) == 0) { // Vergleich der Antworten (Groß-/Kleinschreibung ignoriert)
        $_SESSION['score']++; // Punktestand erhöhen
        $response = "Richtig!"; // Erfolgsnachricht
        $response_class = 'success'; // Erfolgsfarbe
    } else {
        $response = "Falsch! Die richtige Antwort wäre: " . $correct_answer; // Fehlermeldung mit richtiger Antwort
        $response_class = 'danger'; // Fehlerfarbe
    }

    // Zur nächsten Frage wechseln
    $_SESSION['current_question']++;

    // Prüfen, ob der Test abgeschlossen ist
    if ($_SESSION['current_question'] >= count($_SESSION['vokabeln'])) {
        header("Location: endseite.php"); // Zur Endseite weiterleiten
        exit();
    }
}

// Aktuelle Frage und Vokabel aus der Session abrufen
$current_question = $_SESSION['current_question'];
$vokabel = $_SESSION['vokabeln'][$current_question];
?>


<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Vokabeltest</title>
    <!-- Bootstrap CSS für Styling -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons für das Mikrofon-Icon -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <!-- Externe CSS-Datei für das Styling der Seite -->
    <link rel="stylesheet" href="test.css">
    <!-- Script für die Sprachausgabe -->
    <script src="https://code.responsivevoice.org/responsivevoice.js"></script>
    <script>
        // Funktion zur Sprachausgabe der Benutzereingabe
        function speakUserInput() {
            const userInput = document.querySelector('input[name="user_answer"]').value; // Benutzereingabe abrufen
            if (userInput) {
                responsiveVoice.speak(userInput, "US English Male"); // Sprachausgabe mit männlicher Stimme
            } else {
                alert("Bitte gib ein Wort ein, das vorgelesen werden soll."); // Warnung bei leerer Eingabe
            }
        }
    </script>
</head>
<body class="bg-light">

<!-- Hauptcontainer -->
<div class="container">
    <div class="form-container">
        <!-- Überschrift und Anweisungen -->
        <h2>Vokabeltest</h2>
        <p>Übersetze das Wort auf Englisch:</p>
        <h3><?php echo htmlspecialchars($vokabel['deutsches_Wort']); ?></h3> <!-- Deutsches Wort anzeigen -->

        <!-- Formular zur Eingabe der Antwort -->
        <form method="POST" class="d-flex flex-column gap-3">
            <!-- Eingabefeld und Mikrofonbutton -->
            <div class="input-group">
                <input type="text" name="user_answer" class="form-control" placeholder="Deine Antwort" required>
                <button type="button" onclick="speakUserInput();" class="microphone-button">
                    <i class="bi bi-mic-fill"></i> <!-- Mikrofon-Icon -->
                </button>
            </div>

            <!-- Feedback-Nachricht bei richtiger oder falscher Antwort -->
            <?php if (isset($response)): ?>
                <div class="mt-1 alert alert-<?php echo $response_class; ?>">
                    <?php echo $response; ?>
                </div>
            <?php endif; ?>

            <!-- Buttons für Antwort absenden und Test abbrechen -->
            <div class="button-container">
                <form method="POST">
                    <button type="submit" name="submit_answer" class="btn btn-lila">Antwort absenden</button>
                </form>
                <form method="POST">
                    <button type="submit" name="cancel_test" class="btn btn-secondary">Test abbrechen</button>
                </form>
            </div>
        </form>
    </div>
</div>
</body>
</html>
