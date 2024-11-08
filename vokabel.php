<?php
session_start();
if(!isset($_SESSION["username"])){
  header("Location: index.php");
  exit;
}
 ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <h1>Willkommen in deinem Vokabeltrainer!</h1>

    <?php
$host = "localhost";
$name = "vokabeln_db";
$user = "root";
$passwort = "";

try {
    $mysql = new PDO("mysql:host=$host;dbname=$name", $user, $passwort);
    $mysql->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Wenn der Button "Test starten" geklickt wird
    if (isset($_POST['start_test'])) {
        header("Location: test.php"); // Weiterleitung zu einer Seite, die den Test anzeigt
        exit();
    }
    // Wenn der Button "Vokabeln hinzufügen" geklickt wird
    if (isset($_POST['vokabeln_hinzufuegen'])) {
        header("Location: vokabeln_hinzufuegen.php"); // Weiterleitung zu einer Seite zum Hinzufügen von Vokabeln
        exit();
    }
    // Wenn der Button "Vokabeln anzeigen" geklickt wird
    if (isset($_POST['vokabeln_anzeigen'])) {
        header("Location: vokabeln_anzeigen.php"); // Weiterleitung zu einer Seite, die die Vokabeln anzeigt
        exit();
    }
} catch (PDOException $e) {
    echo "Verbindungsfehler: " . $e->getMessage();
}
?>

<!-- Startseite mit Buttons -->
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vokabeltrainer</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin-top: 50px;
        }
        .button-container {
            margin-top: 20px;
        }
        button {
            padding: 10px 20px;
            font-size: 18px;
            cursor: pointer;
            margin: 10px;
        }
    </style>
</head>
<body>
    <h2>Teste jetzt deine Englischkentnisse</h2>
    <p>Wähle eine Option, um fortzufahren:</p>

    <div class="button-container">
        <!-- Button zum Test starten -->
        <form method="POST">
            <button type="submit" name="start_test">Test starten</button>
        </form>

        <!-- Button zum Vokabeln hinzufügen -->
        <form method="POST">
            <button type="submit" name="vokabeln_hinzufuegen">Vokabeln hinzufügen</button>
        </form>

        <!-- Button zum Vokabeln anzeigen -->
        <form method="POST">
            <button type="submit" name="vokabeln_anzeigen">Vokabeln anzeigen</button>
        </form>
    </div>
</body>
</html>

  </body>
</html>