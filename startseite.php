<?php
session_start();

// Sicherstellen, dass der Benutzer eingeloggt ist
if(!isset($_SESSION["username"])){
  header("Location: index.php");
  exit;
}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
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
    <h1>Willkommen in deinem Vokabeltrainer!</h1>

    <?php
    // Datenbankverbindung herstellen
    $host = "localhost";
    $name = "vokabeln_db";
    $user = "root";
    $passwort = "";

    try {
        $mysql = new PDO("mysql:host=$host;dbname=$name", $user, $passwort);
        $mysql->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Button-Handling
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['start_test'])) {
                // Weiterleitung zu test.php
                header("Location: test.php");
                exit();
            } elseif (isset($_POST['vokabeln_hinzufuegen'])) {
                // Weiterleitung zu vokabeln_hinzufuegen.php
                header("Location: vokabeln_hinzufuegen.php");
                exit();
            } elseif (isset($_POST['vokabeln_anzeigen'])) {
                // Weiterleitung zu vokabeln_anzeigen.php
                header("Location: vokabeln_anzeigen.php");
                exit();
            }
        }
    } catch (PDOException $e) {
        echo "Verbindungsfehler: " . $e->getMessage();
    }
    ?>

    <!-- Startseite mit Buttons -->
    <h2>Teste jetzt deine Englischkenntnisse</h2>
    <p>Wähle eine Option, um fortzufahren:</p>

    <div class="button-container">
        <!-- Ein Formular für alle Buttons -->
        <form method="POST">
            <!-- Button zum Test starten -->
            <button type="submit" name="start_test">Test starten</button>

            <!-- Button zum Vokabeln hinzufügen -->
            <button type="submit" name="vokabeln_hinzufuegen">Vokabeln hinzufügen</button>

            <!-- Button zum Vokabeln anzeigen -->
            <button type="submit" name="vokabeln_anzeigen">Vokabeln anzeigen</button>
        </form>
    </div>

  </body>
</html>
