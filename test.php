<?php
session_start();  // Sitzung fortsetzen

// Datenbankverbindung einbinden
require_once('mysql-vokabel.php');

// Falls keine Vokabel in der Sitzung gespeichert ist, zurück zur Startseite
if (!isset($_SESSION['vokabel'])) {
    header("Location: startseite.php");
    exit();
}

// Vokabel aus der Sitzung holen
$vokabel = $_SESSION['vokabel'];
$punkte = $_SESSION['punkte'];

// Wenn der Benutzer eine Antwort eingibt
if (isset($_POST['antwort'])) {
    $antwort = trim($_POST['antwort']);  // Antwort trimmen (Leerzeichen entfernen)
    if (strtolower($antwort) == strtolower($vokabel['englisches_Wort'])) {
        $_SESSION['punkte']++;  // Punkte erhöhen, wenn die Antwort richtig ist
        $feedback = "Richtig!";
    } else {
        $feedback = "Falsch! Die richtige Antwort war: " . $vokabel['englisches_Wort'];
    }

    // Neue Vokabel für die nächste Frage abrufen
    $stmt = $mysql->query("SELECT * FROM Vokabeln ORDER BY RAND() LIMIT 1");
    $vokabel = $stmt->fetch(PDO::FETCH_ASSOC);

    // Vokabel in der Sitzung speichern
    $_SESSION['vokabel'] = $vokabel;
}

?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Vokabeltest - Frage</title>
</head>
<body>
    <h1>Übersetze ins Englische:</h1>
    <p><?php echo htmlspecialchars($vokabel['deutsches_Wort']); ?></p>

    <?php if (isset($feedback)) { echo "<p>$feedback</p>"; } ?>

    <form method="POST">
        <input type="text" name="antwort" required>
        <button type="submit">Antwort überprüfen</button>
    </form>

    <p>Du hast bisher <?php echo $punkte; ?> Punkte.</p>
</body>
</html>
