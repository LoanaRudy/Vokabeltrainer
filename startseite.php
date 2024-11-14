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
    <style>
        .btn-lila {
            background-color: #D8A7E4;
            color: black;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            flex: 1;
        }
        .btn-lila:hover {
            background-color: #C18ED3;
        }
        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }
        .form-container {
            width: 100%;
            max-width: 600px; /* Breiterer Container */
            padding: 30px;
            border: 1px solid #ccc;
            border-radius: 8px;
            background-color: #fff;
            text-align: center;
        }
        .button-container {
            display: flex;
            gap: 15px;
            justify-content: center;
            margin-top: 25px;
        }
        h1, h2, p {
            color: black;
        }
    </style>
</head>
<body class="bg-light">

<div class="container">
    <div class="form-container">
        <h1>Herzlich Willkommen in deinem Vokabeltrainer!</h1>
        <p></p>
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







