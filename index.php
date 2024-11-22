<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="index.css">
</head>
<body class="bg-light">

<div class="container">
    <div class="form-container">
        <?php
        $error_message = ""; // Initialisiere die Fehlermeldung als leer

        if (isset($_POST["submit"])) {
            require("mysql.php");
            $stmt = $mysql->prepare("SELECT * FROM accounts WHERE USERNAME = :user");
            $stmt->bindParam(":user", $_POST["username"]);
            $stmt->execute();
            $count = $stmt->rowCount();

            if ($count == 1) {
                $row = $stmt->fetch();
                if (password_verify($_POST["pw"], $row["PASSWORD"])) {
                    session_start();
                    $_SESSION["username"] = $row["USERNAME"];
                    header("Location: startseite.php");
                    exit();
                } else {
                    $error_message = "Der Login ist fehlgeschlagen.";
                }
            } else {
                $error_message = "Der Login ist fehlgeschlagen.";
            }
        }
        ?>

        <h1>Anmelden</h1>

        <!-- Login-Formular -->
        <form action="index.php" method="post">
            <input type="text" name="username" class="form-control" placeholder="Username" required>
            <input type="password" name="pw" class="form-control" placeholder="Passwort" required>

            <!-- Fehlermeldung unter dem Passwort-Eingabefeld -->
            <?php if (!empty($error_message)): ?>
                <div class="alert alert-danger mt-2"><?php echo $error_message; ?></div>
            <?php endif; ?>

            <button type="submit" name="submit" class="btn btn-lila w-100">Einloggen</button>
        </form>

        <!-- Link zur Registrierungsseite -->
        <div class="text-center mt-3">
            <a href="register.php">Noch keinen Account?</a>
        </div>
    </div>
</div>

</body>
</html>
