<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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
        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .form-container {
            background-color: #f9f9f9;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }
        .form-control {
            margin-bottom: 15px;
        }
        .text-center {
            text-align: center;
        }
    </style>
</head>
<body class="bg-light">

<div class="container">
    <div class="form-container">
        <?php
        if (isset($_POST["submit"])) {
            require("mysql.php");
            $stmt = $mysql->prepare("SELECT * FROM accounts WHERE USERNAME = :user"); //Username überprüfen
            $stmt->bindParam(":user", $_POST["username"]);
            $stmt->execute();
            $count = $stmt->rowCount();
            if ($count == 1) {
                //Username ist frei
                $row = $stmt->fetch();
                if (password_verify($_POST["pw"], $row["PASSWORD"])) {
                    session_start();
                    $_SESSION["username"] = $row["USERNAME"];
                    header("Location: startseite.php");
                    exit();
                } else {
                    echo '<div class="alert alert-danger text-center">Der Login ist fehlgeschlagen.</div>';
                }
            } else {
                echo '<div class="alert alert-danger text-center">Der Login ist fehlgeschlagen.</div>';
            }
        }
        ?>

        <h1>Anmelden</h1>

        <!-- Login-Formular -->
        <form action="index.php" method="post">
            <input type="text" name="username" class="form-control" placeholder="Username" required>
            <input type="password" name="pw" class="form-control" placeholder="Passwort" required>
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
