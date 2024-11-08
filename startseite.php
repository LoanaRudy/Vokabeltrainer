<?php
session_start();  // Sitzung starten, um später Daten zu speichern

// Datenbankverbindung einbinden
require_once('mysql-vokabel.php');

// Wenn der Test gestartet wurde
if (isset($_POST['startseite'])) {
    // Zufällige Vokabel aus der Datenbank abrufen
    $stmt = $mysql->query("SELECT * FROM Vokabeln ORDER BY RAND() LIMIT 1");
    $vokabel = $stmt->fetch(PDO::FETCH_ASSOC);

    // Vokabel in der Sitzung speichern
    $_SESSION['vokabel'] = $vokabel;
    $_SESSION['punkte'] = 0;  // Punkte zurücksetzen
    $_SESSION['index'] = 0;   // Index zurücksetzen (falls du mehrere Fragen haben möchtest)

    // Weiter zur Testseite
    header("Location: test.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Vokabeltest</title>
</head>
<body>
    <h1>Vokabeltest</h1>
    <form method="POST">
        <button type="submit" name="startseite">Test starten</button>
    </form>
</body>
</html>

