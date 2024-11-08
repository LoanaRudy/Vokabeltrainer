<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Account erstellen</title>
  </head>
  <body>
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
          echo "Die Passwörter stimmen nicht überein.";
        }
      } else {
        echo "Der Username ist bereits vergeben.";
      }
    }
    ?>
    
    <h1>Account erstellen</h1>
    <form action="register.php" method="post">
      <input type="text" name="username" placeholder="Username" required><br>
      <input type="password" name="pw" placeholder="Passwort" required><br>
      <input type="password" name="pw2" placeholder="Passwort wiederholen" required><br>
      <button type="submit" name="submit">Erstellen</button>
    </form>
    
    <br>
    <a href="index.php">Hast du bereits einen Account?</a>
  </body>
</html>
