<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8"> <!-- Zeichensatz UTF-8 für internationale Zeichen -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Optimierung für mobile Geräte -->
    <title>Login</title> <!-- Titel der Seite -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"> <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="index.css"> <!-- Externe CSS-Datei für individuelles Styling -->
</head>
<body class="bg-light"> <!-- Hintergrundfarbe auf helles Grau gesetzt -->

<div class="container"> <!-- Hauptcontainer für das Layout -->
    <div class="form-container"> <!-- Container für das Login-Formular -->
        <?php
        $error_message = ""; // Initialisiert die Fehlermeldung als leer

        if (isset($_POST["submit"])) { // Überprüft, ob das Formular abgeschickt wurde
            require("mysql.php"); // Verbindung zur Datenbank herstellen

            // Überprüft, ob der eingegebene Benutzername in der Datenbank existiert
            $stmt = $mysql->prepare("SELECT * FROM accounts WHERE USERNAME = :user");
            $stmt->bindParam(":user", $_POST["username"]); // Binded den eingegebenen Benutzernamen
            $stmt->execute(); // Führt die Abfrage aus
            $count = $stmt->rowCount(); // Zählt die Anzahl der gefundenen Datensätze

            if ($count == 1) { // Wenn ein Benutzername gefunden wurde
                $row = $stmt->fetch(); // Holt die Daten des Benutzers
                if (password_verify($_POST["pw"], $row["PASSWORD"])) { // Prüft das eingegebene Passwort
                    session_start(); // Startet die Session
                    $_SESSION["username"] = $row["USERNAME"]; // Speichert den Benutzernamen in der Session
                    header("Location: startseite.php"); // Leitet zur Startseite weiter
                    exit(); // Beendet das Skript nach der Weiterleitung
                } else {
                    $error_message = "Der Login ist fehlgeschlagen."; // Fehlermeldung bei falschem Passwort
                }
            } else {
                $error_message = "Der Login ist fehlgeschlagen."; // Fehlermeldung bei unbekanntem Benutzer
            }
        }
        ?>

        <h1>Anmelden</h1> <!-- Überschrift für das Formular -->

        <!-- Login-Formular -->
        <form action="index.php" method="post"> <!-- Formular, das Daten an sich selbst sendet -->
            <input type="text" name="username" class="form-control" placeholder="Username" required> <!-- Eingabefeld für den Benutzernamen -->
            <input type="password" name="pw" class="form-control" placeholder="Passwort" required> <!-- Eingabefeld für das Passwort -->

            <!-- Anzeige der Fehlermeldung, falls vorhanden -->
            <?php if (!empty($error_message)): ?>
                <div class="alert alert-danger mt-2"><?php echo $error_message; ?></div> <!-- Fehlermeldung unter dem Passwortfeld -->
            <?php endif; ?>

            <button type="submit" name="submit" class="btn btn-lila w-100">Einloggen</button> <!-- Login-Button -->
        </form>

        <!-- Link zur Registrierungsseite -->
        <div class="text-center mt-3">
            <a href="register.php">Noch keinen Account?</a> <!-- Link für Benutzer, die noch keinen Account haben -->
        </div>
    </div>
</div>

</body>
</html>
