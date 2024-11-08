<?php
session_start();  // Sitzung fortsetzen

// Prüfen, ob Punkte vorhanden sind
if (!isset($_SESSION['punkte'])) {
    header("Location: startseite.php");
    exit();
}

$punkte = $_SESSION['punkte'];
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Vokabeltest - Ergebnis</title>
</head>
<body>
    <h1>Test abgeschlossen!</h1>
    <p>Du hast <?php echo $punkte; ?> von 10 Punkten erreicht.</p>
    <form method="POST" action="startseite.php">
        <button type="submit">Neuen Test starten</button>
    </form>
</body>
</html>
