<?php
session_start(); // Startet die PHP-Session, um Benutzerdaten zwischen den Seiten zu speichern

// Aktiviert die Fehlerprotokollierung und zeigt alle Fehler an (Debugging)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Überprüfen, ob der Benutzer eingeloggt ist
if (!isset($_SESSION["username"])) {
    header("Location: index.php"); // Weiterleitung zur Login-Seite, falls nicht eingeloggt
    exit;
}

// Logout-Logik: Beendet die Sitzung, wenn der Logout-Button geklickt wird
if (isset($_POST['logout'])) {
    session_destroy(); // Löscht alle Session-Daten
    header("Location: index.php"); // Weiterleitung zur Login-Seite
    exit();
}

// Logik für den Start des Tests
if (isset($_POST['start_test'])) {
    try {
        require_once(__DIR__ . '/mysql-vokabel.php'); // Stellt die Verbindung zur Datenbank her
        $stmt = $mysql->query("SELECT * FROM Vokabeln"); // Ruft alle Vokabeln aus der Datenbank ab

        if ($stmt) {
            $_SESSION['vokabeln'] = $stmt->fetchAll(PDO::FETCH_ASSOC); // Speichert alle Vokabeln in der Session
            $_SESSION['current_question'] = 0; // Initialisiert die erste Frage
            $_SESSION['score'] = 0; // Initialisiert den Punktestand
            $_SESSION['test_started'] = true; // Markiert den Test als gestartet

            header("Location: test.php"); // Weiterleitung zur Testseite
            exit();
        } else {
            echo "Fehler bei der Datenbankabfrage."; // Fehler, wenn die Abfrage fehlschlägt
        }
    } catch (PDOException $e) {
        // Gibt einen Fehler aus, wenn die Verbindung zur Datenbank fehlschlägt
        echo "Fehler bei der Verbindung zur Datenbank: " . $e->getMessage();
    }
}
?>


<!DOCTYPE html>
<html lang="de">
<head>
    
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vokabeltrainer</title>
    
    <!-- Bootstrap CSS Einbindung -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link rel="stylesheet" href="startseite.css">
</head>
<body class="bg-light"> 

<div class="container">
    <div class="form-container">
        <!-- Logout-Button oben links -->
        <form method="POST">
            <button type="submit" name="logout" class="btn-logout">Logout</button> <!-- Beendet die Sitzung -->
        </form>

        <!-- Begrüßungstext -->
        <h1>Herzlich Willkommen in deinem Vokabeltrainer!</h1>
        <p></p>
        <h2>Teste jetzt deine Englischkenntnisse</h2>
        <p></p>
        <p>Wähle eine Option, um fortzufahren...</p>

        <!-- Hauptaktionen als Buttons -->
        <div class="button-container">
            <!-- Button zum Starten des Tests -->
            <form method="POST">
                <button type="submit" name="start_test" class="btn btn-lila">Test starten</button>
            </form>

            <!-- Button zum Hinzufügen von Vokabeln -->
            <form method="GET" action="vokabel-hinzufuegen.php">
                <button type="submit" class="btn btn-lila">Vokabeln hinzufügen</button>
            </form>

            <!-- Button zur Verwaltung von Vokabeln -->
            <form method="GET" action="vokabeln-verwalten.php">
                <button type="submit" class="btn btn-lila">Vokabeln verwalten</button>
            </form>
        </div>
    </div>
</div>

</body>
</html>
