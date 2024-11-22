<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8"> <!-- Zeichensatz auf UTF-8 gesetzt -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Responsives Design aktiviert -->
    <title>Account erstellen</title> <!-- Seitentitel -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"> <!-- Bootstrap CSS eingebunden -->
    <link rel="stylesheet" href="register.css"> <!-- Externe CSS-Datei für individuelles Styling -->
</head>
<body class="bg-light"> <!-- Heller Hintergrund für die gesamte Seite -->

<div class="container"> <!-- Hauptcontainer für zentrierte Inhalte -->
    <div class="form-container"> <!-- Container für das Registrierungsformular -->
        <?php
        // Überprüft, ob das Formular abgesendet wurde
        if (isset($_POST["submit"])) {
            require("mysql.php");  // Datenbankverbindung herstellen
            
            // Überprüfen, ob der Username bereits existiert
            $stmt = $mysql->prepare("SELECT * FROM accounts WHERE USERNAME = :user");
            $stmt->bindParam(":user", $_POST["username"]); // Bindet den eingegebenen Username
            $stmt->execute();
            $count = $stmt->rowCount(); // Anzahl der gefundenen Zeilen

            // Wenn kein Benutzer mit diesem Namen existiert
            if ($count == 0) {
                // Überprüfen, ob die Passwörter übereinstimmen
                if ($_POST["pw"] == $_POST["pw2"]) {
                    // Benutzer in der Datenbank anlegen
                    $stmt = $mysql->prepare("INSERT INTO accounts (USERNAME, PASSWORD) VALUES (:user, :pw)");
                    $stmt->bindParam(":user", $_POST["username"]); // Bindet den eingegebenen Username
                    
                    // Passwort hashen
                    $hash = password_hash($_POST["pw"], PASSWORD_BCRYPT);
                    $stmt->bindParam(":pw", $hash); // Bindet das gehashte Passwort
                    $stmt->execute();

                    // Erfolgreiche Registrierung -> Weiterleitung zur Startseite
                    header("Location: startseite.php");
                    exit(); // Beendet das Skript nach der Weiterleitung
                } else {
                    // Fehlermeldung, wenn die Passwörter nicht übereinstimmen
                    echo '<div class="alert alert-danger text-center">Die Passwörter stimmen nicht überein.</div>';
                }
            } else {
                // Fehlermeldung, wenn der Username bereits vergeben ist
                echo '<div class="alert alert-danger text-center">Der Username ist bereits vergeben.</div>';
            }
        }
        ?>

        <h1>Account erstellen</h1> <!-- Überschrift des Formulars -->

        <!-- Registrierungsformular -->
        <form action="register.php" method="post">
            <!-- Eingabefeld für den Username -->
            <input type="text" name="username" class="form-control" placeholder="Username" required>
            <!-- Eingabefeld für das Passwort -->
            <input type="password" name="pw" class="form-control" placeholder="Passwort" required>
            <!-- Eingabefeld für die Passwort-Wiederholung -->
            <input type="password" name="pw2" class="form-control" placeholder="Passwort wiederholen" required>
            <!-- Button zum Absenden des Formulars -->
            <button type="submit" name="submit" class="btn btn-lila w-100">Erstellen</button>
        </form>

        <!-- Link zur Login-Seite -->
        <div class="text-center mt-3">
            <a href="index.php">Hast du bereits einen Account?</a> <!-- Verweist auf die Login-Seite -->
        </div>
    </div>
</div>

</body>
</html>

