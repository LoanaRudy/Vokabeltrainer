<?php
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: index.php");
    exit;
}

// Vokabel aus der Session holen
$vokabel = $_SESSION['vokabel'];

// Überprüfen, ob die Antwort eingereicht wurde
if (isset($_POST['antwort'])) {
    $userAntwort = strtolower(trim($_POST['antwort']));  // Eingabe normalisieren
    $richtigeAntwort = strtolower(trim($vokabel['englisches_Wort']));  // Korrekte Antwort normalisieren

    // Ergebnis ausgeben
    if ($userAntwort === $richtigeAntwort) {
        echo "<h1 style='color: green;'>Richtig!</h1>";
        echo "<p>Die Übersetzung von <strong>{$vokabel['deutsches_Wort']}</strong> lautet tatsächlich <strong>{$vokabel['englisches_Wort']}</strong>.</p>";
        $_SESSION['punkte'] = isset($_SESSION['punkte']) ? $_SESSION['punkte'] + 1 : 1;
    } else {
        echo "<h1 style='color: red;'>Falsch!</h1>";
        echo "<p>Die richtige Übersetzung von <strong>{$vokabel['deutsches_Wort']}</strong> lautet <strong>{$vokabel['englisches_Wort']}</strong>, nicht <strong>{$userAntwort}</strong>.</p>";
    }
    
    // Punkteanzeige
    echo "<p>Punkte: {$_SESSION['punkte']}</p>";
    
    // Vokabel aus der Session entfernen, um eine neue Frage beim nächsten Test zu ermöglichen
    unset($_SESSION['vokabel']);
}
?>

<!-- Buttons für die nächsten Aktionen -->
<form action="test.php" method="POST">
    <button type="submit" name="next_question" style="padding: 10px 20px; font-size: 18px; margin-top: 20px;">Nächste Frage</button>
</form>

<form action="startseite.php" method="POST">
    <button type="submit" name="go_home" style="padding: 10px 20px; font-size: 18px; margin-top: 20px;">Zurück zur Startseite</button>
</form>
