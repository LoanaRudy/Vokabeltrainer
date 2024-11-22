<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account erstellen</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="register.css">
</head>
<body class="bg-light">

<div class="container">
    <div class="form-container">
        <?php
        if (isset($_POST["submit"])) {
            require("mysql.php");  // Verbindung zur Datenbank herstellen
            
            // Username überprüfen
            $stmt = $mysql->prepare("SELECT * FROM accounts WHERE USERNAME = :user");
            $stmt->bindParam(":user", $_POST["username"]);
            $stmt->execute();
            $count = $stmt->rowCount();
            
            if ($count == 0) {
                // Username ist frei
                if ($_POST["pw"] == $_POST["pw2"]) {
                    // Passwörter stimmen überein, User anlegen
                    $stmt = $mysql->prepare("INSERT INTO accounts (USERNAME, PASSWORD) VALUES (:user, :pw)");
                    $stmt->bindParam(":user", $_POST["username"]);
                    
                    // Passwort hashen
                    $hash = password_hash($_POST["pw"], PASSWORD_BCRYPT);
                    $stmt->bindParam(":pw", $hash);
                    $stmt->execute();
                    
                    // Account erfolgreich erstellt, zur Startseite weiterleiten
                    header("Location: startseite.php");
                    exit();  // Beendet das Skript nach der Weiterleitung
                    
                } else {
                    echo '<div class="alert alert-danger text-center">Die Passwörter stimmen nicht überein.</div>';
                }
            } else {
                echo '<div class="alert alert-danger text-center">Der Username ist bereits vergeben.</div>';
            }
        }
        ?>

        <h1>Account erstellen</h1>

        <!-- Registrierungsformular -->
        <form action="register.php" method="post">
            <input type="text" name="username" class="form-control" placeholder="Username" required>
            <input type="password" name="pw" class="form-control" placeholder="Passwort" required>
            <input type="password" name="pw2" class="form-control" placeholder="Passwort wiederholen" required>
            <button type="submit" name="submit" class="btn btn-lila w-100">Erstellen</button>
        </form>

        <!-- Link zur Login-Seite -->
        <div class="text-center mt-3">
            <a href="index.php">Hast du bereits einen Account?</a>
        </div>
    </div>
</div>

</body>
</html>
