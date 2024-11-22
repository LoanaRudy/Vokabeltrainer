<?php
session_start(); // Session starten

// Fehlerprotokollierung aktivieren
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Wenn der Nutzer nicht eingeloggt ist, zur Login-Seite weiterleiten
if (!isset($_SESSION["username"])) {
    header("Location: index.php");
    exit;
}

// Logout-Logik: Wenn der Logout-Button geklickt wird, Sitzung beenden und zur Login-Seite weiterleiten
if (isset($_POST['logout'])) {
    session_destroy();
    header("Location: index.php");
    exit();
}

// Wenn der Button "Test starten" geklickt wurde, die Session-Variablen setzen und zu test.php weiterleiten
if (isset($_POST['start_test'])) {
    try {
        require_once(__DIR__ . '/mysql-vokabel.php');  // DB-Verbindung herstellen
        $stmt = $mysql->query("SELECT * FROM Vokabeln");
        if ($stmt) {
            $_SESSION['vokabeln'] = $stmt->fetchAll(PDO::FETCH_ASSOC);  // Alle Vokabeln in der Session speichern
            $_SESSION['current_question'] = 0;  // Setzt die erste Frage
            $_SESSION['score'] = 0;  // Initialisiert den Punktestand
            $_SESSION['test_started'] = true;  // Test als gestartet markieren

            // Weiterleitung zur Testseite
            header("Location: test.php");
            exit();
        } else {
            echo "Fehler bei der Datenbankabfrage.";
        }
    } catch (PDOException $e) {
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="startseite.css">
</head>
<body class="bg-light">

<div class="container">
    <div class="form-container">
        <!-- Logout-Button in der linken oberen Ecke -->
        <form method="POST">
            <button type="submit" name="logout" class="btn-logout">Logout</button>
        </form>

        <h1>Herzlich Willkommen in deinem Vokabeltrainer!</h1>
        <h2>Teste jetzt deine Englischkenntnisse</h2>
        <p>Wähle eine Option, um fortzufahren...</p>

        <div class="button-container">
            <!-- Button zum Test starten -->
            <form method="POST">
                <button type="submit" name="start_test" class="btn btn-lila">Test starten</button>
            </form>

            <!-- Button zum Vokabeln hinzufügen -->
            <form method="GET" action="vokabel-hinzufuegen.php">
                <button type="submit" class="btn btn-lila">Vokabeln hinzufügen</button>
            </form>

            <!-- Button zum Vokabeln verwalten -->
            <form method="GET" action="vokabeln-verwalten.php">
                <button type="submit" class="btn btn-lila">Vokabeln verwalten</button>
            </form>
        </div>
    </div>
</div>

</body>
</html>






