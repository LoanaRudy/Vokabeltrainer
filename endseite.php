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
    <link rel="stylesheet" href="endseite.css">
</head>
<body class="bg-light">

<div class="container">
    <div class="form-container">
        <h1>Herzlichen Glückwunsch!</h1>
        <p>Du hast den Test beendet.</p>
        <h2>Deine Punktzahl:</h2>
        <p><?php echo $score; ?> von <?php echo $total_questions; ?></p>

        <!-- Buttons: Zurück zur Startseite und Test wiederholen -->
        <div class="button-container">
            <form method="POST" action="startseite.php">
                <button type="submit" class="btn btn-lila">Zurück zur Startseite</button>
            </form>

            <form method="POST" action="test.php">
                <input type="hidden" name="restart_test" value="1">
                <button type="submit" class="btn btn-lila">Test wiederholen</button>
            </form>
        </div>
    </div>
</div>

</body>
</html>


