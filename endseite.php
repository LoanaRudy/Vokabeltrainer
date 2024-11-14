<?php
session_start();

// Überprüfen, ob der Test überhaupt abgeschlossen wurde
if (!isset($_SESSION['test_started'])) {
    header("Location: startseite.php");
    exit();
}

// Testdaten (Punktestand etc.) auslesen
$score = $_SESSION['score'];
$total_questions = count($_SESSION['vokabeln']);

// Session bereinigen, um den Teststatus zurückzusetzen
unset($_SESSION['test_started']);
unset($_SESSION['vokabeln']);
unset($_SESSION['current_question']);
unset($_SESSION['score']);
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test abgeschlossen</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .btn-lila {
            background-color: #D8A7E4; /* Helllila */
            color: black;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
        }
        .btn-lila:hover {
            background-color: #C18ED3; /* Etwas dunkleres Lila */
        }
        .flex-container {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        h1, h2, p {
            color: black;
            text-align: center; /* Zentriert den Text */
        }
        .button-container {
            display: flex;
            gap: 15px;
            justify-content: center;
            margin-top: 20px;
        }
    </style>
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="flex-container">
        <h3>Herzlichen Glückwunsch!</h3>
        <p>Du hast den Test beendet.</p>
        <p>Deine Punktzahl: <?php echo $score; ?> von <?php echo $total_questions; ?></p>

        <!-- Buttons: Zurück zur Startseite und Test wiederholen -->
        <div class="button-container">
            <form method="POST" action="startseite.php">
                <button type="submit" class="btn btn-lila btn-lg">Zurück zur Startseite</button>
            </form>

            <!-- Button zum Wiederholen des Tests -->
            <form method="POST" action="test.php">
                <!-- Neue Logik: den Test-Status explizit zurücksetzen -->
                <input type="hidden" name="restart_test" value="1">
                <button type="submit" class="btn btn-lila btn-lg">Test wiederholen</button>
            </form>
        </div>
    </div>
</div>

</body>
</html>
