<?php
// Starten der PHP-Session
session_start();

// Überprüfen, ob der Benutzer eingeloggt ist
if (!isset($_SESSION["username"])) {
    // Wenn der Benutzer nicht eingeloggt ist, leite ihn zur Login-Seite weiter
    header("Location: index.php");
    exit;
}

// Vokabel aus der Session abrufen
$vokabel = $_SESSION['vokabel'];

// Überprüft, ob der Benutzer eine Antwort gegeben hat
if (isset($_POST['antwort'])) {
    // Benutzerantwort normalisieren: in Kleinbuchstaben umwandeln und Leerzeichen entfernen
    $userAntwort = strtolower(trim($_POST['antwort']));
    // Korrekte Antwort aus der Vokabel normalisieren
    $richtigeAntwort = strtolower(trim($vokabel['englisches_Wort']));

    // Überprüfen, ob die Antwort korrekt ist
    if ($userAntwort === $richtigeAntwort) {
        // Wenn korrekt, Erfolgsmeldung anzeigen
        echo "<h1 style='color: green;'>Richtig!</h1>";
        echo "<p>Die Übersetzung von <strong>{$vokabel['deutsches_Wort']}</strong> lautet tatsächlich <strong>{$vokabel['englisches_Wort']}</strong>.</p>";

        // Punktestand in der Session aktualisieren oder initialisieren
        $_SESSION['punkte'] = isset($_SESSION['punkte']) ? $_SESSION['punkte'] + 1 : 1;
        
    } else {
        // Wenn falsch, Fehlermeldung und korrekte Antwort anzeigen
        echo "<h1 style='color: red;'>Falsch!</h1>";
        echo "<p>Die richtige Übersetzung von <strong>{$vokabel['deutsches_Wort']}</strong> lautet <strong>{$vokabel['englisches_Wort']}</strong>, nicht <strong>{$userAntwort}</strong>.</p>";
    }

    // Punktestand des Benutzers anzeigen
    echo "<p>Punkte: {$_SESSION['punkte']}</p>";

    // Die aktuelle Vokabel aus der Session entfernen, um beim nächsten Test eine neue Vokabel zu laden
    unset($_SESSION['vokabel']);
}
?>

<!-- Formular für den Button "Nächste Frage" -->
<form action="test.php" method="POST">
    <button type="submit" name="next_question" style="padding: 10px 20px; font-size: 18px; margin-top: 20px;">Nächste Frage</button>
</form>

<!-- Formular für den Button "Zurück zur Startseite" -->
<form action="startseite.php" method="POST">
    <button type="submit" name="go_home" style="padding: 10px 20px; font-size: 18px; margin-top: 20px;">Zurück zur Startseite</button>
</form>
