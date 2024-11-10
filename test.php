<?php
session_start();

// Überprüfen, ob der Nutzer angemeldet ist
if (!isset($_SESSION["username"])) {
    header("Location: index.php");
    exit;
}

// Datenbankverbindung herstellen
require_once('mysql-vokabel.php');

// Wenn der Test gestartet wird
if (!isset($_SESSION['test_started'])) {
    $stmt = $mysql->query("SELECT * FROM Vokabeln");
    $_SESSION['vokabeln'] = $stmt->fetchAll(PDO::FETCH_ASSOC);  // Speichert alle Vokabeln in der Session
    $_SESSION['test_started'] = true;  // Markiert den Test als gestartet
    $_SESSION['current_question'] = 0; // Setzt die aktuelle Frage auf 0
    $_SESSION['score'] = 0; // Initialisiert den Punktestand
}

// Wenn die Antwort abgesendet wurde
if (isset($_POST['submit_answer'])) {
    $user_answer = trim($_POST['user_answer']);
    $correct_answer = trim($_SESSION['vokabeln'][$_SESSION['current_question']]['englisches_Wort']);

    // Antwort überprüfen
    if (strcasecmp($user_answer, $correct_answer) == 0) {
        $_SESSION['score']++;
        $response = "Richtig!";
        $response_class = 'success';  // Erfolgsanzeige (grün)
    } else {
        $response = "Falsch! Die richtige Antwort wäre: " . $correct_answer;
        $response_class = 'danger';  // Fehleranzeige (rot)
    }

    $_SESSION['current_question']++;

    // Wenn alle Fragen durch sind, Test beenden
    if ($_SESSION['current_question'] >= count($_SESSION['vokabeln'])) {
        header("Location: endseite.php");
        exit;
    }
}

// Aktuelle Vokabel abrufen
$current_question = $_SESSION['current_question'];
$vokabel = $_SESSION['vokabeln'][$current_question];
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vokabeltest</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Custom Styles */
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
        body {
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: flex-start;
            align-items: flex-start;
            height: 100vh;
            width: 100vw;
        }
        .container {
            padding: 20px; /* Platz nach innen */
        }
        h2, h3, p {
            color: black;
            text-align: left; /* Links ausgerichteter Text */
        }
        .form-control {
            width: 100%;
            max-width: 400px; /* Begrenze die maximale Breite */
        }
    </style>
</head>
<body class="bg-light">

<div class="container">
    <h2>Vokabeltest</h2>

    <!-- Aktuelle Frage -->
    <p>Übersetze das Wort:</p>
    <h3><?php echo $vokabel['deutsches_Wort']; ?></h3>

    <!-- Antwortformular -->
    <form method="POST">
        <input type="text" name="user_answer" class="form-control mb-2" placeholder="Deine Antwort">
        <button type="submit" name="submit_answer" class="btn btn-lila btn-lg">Antwort absenden</button>
    </form>

    <!-- Rückmeldung nach Antwort -->
    <?php if (isset($response)): ?>
        <div class="mt-3 alert alert-<?php echo $response_class; ?>">
            <?php echo $response; ?>
        </div>
    <?php endif; ?>
</div>

</body>
</html>
