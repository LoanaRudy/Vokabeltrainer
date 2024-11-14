<?php
// Session starten
session_start(); 

// Fehlerprotokollierung aktivieren
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Prüfen, ob der Nutzer eingeloggt ist
if (!isset($_SESSION["username"])) {
    header("Location: index.php");
    exit;
}

// Prüfen, ob das Formular zum Hinzufügen einer Vokabel abgeschickt wurde
if (isset($_POST['submit'])) {
    require_once('mysql-vokabel.php');

    // Vokabeln aus dem Formular holen
    $deutsches_wort = $_POST['deutsches_wort'];
    $englisches_wort = $_POST['englisches_wort'];

    if (!empty($deutsches_wort) && !empty($englisches_wort)) {
        $stmt = $mysql->prepare("INSERT INTO Vokabeln (deutsches_Wort, englisches_Wort) VALUES (:deutsch, :englisch)");
        $stmt->execute([
            ':deutsch' => $deutsches_wort,
            ':englisch' => $englisches_wort
        ]);

        $message = "Vokabel erfolgreich hinzugefügt!";
        $message_class = "alert-success";
    } else {
        $message = "Bitte beide Felder ausfüllen!";
        $message_class = "alert-danger";
    }
}
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vokabel Hinzufügen</title>
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
            max-width: 500px;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            background-color: #fff;
        }
        h1 {
            color: black;
            text-align: center;
        }
        .button-container {
            display: flex;
            gap: 15px;
            margin-top: 20px;
        }
    </style>
</head>
<body class="bg-light">

<div class="container">
    <div class="form-container">
        <h2>Neue Vokabel hinzufügen</h2>

        <?php if (isset($message)): ?>
            <div class="alert <?php echo $message_class; ?> mt-3"><?php echo $message; ?></div>
        <?php endif; ?>

        <!-- Formular zum Hinzufügen einer Vokabel -->
        <form method="POST" action="vokabel-hinzufuegen.php">
            <div class="mb-3">
                <label for="deutsches_wort" class="form-label">Deutsches Wort</label>
                <input type="text" class="form-control" id="deutsches_wort" name="deutsches_wort" required>
            </div>

            <div class="mb-3">
                <label for="englisches_wort" class="form-label">Englisches Wort</label>
                <input type="text" class="form-control" id="englisches_wort" name="englisches_wort" required>
            </div>

            <div class="button-container">
                <button type="submit" name="submit" class="btn btn-lila">Vokabel hinzufügen</button>
                <a href="startseite.php" class="btn btn-lila">Zurück zur Startseite</a>
            </div>
        </form>
    </div>
</div>

</body>
</html>



