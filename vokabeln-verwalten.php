<?php
// Startet die PHP-Session, um Zugriff auf Session-Variablen zu erhalten
session_start(); 

// Aktiviert die Fehleranzeige für Debugging-Zwecke
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Überprüft, ob der Benutzer eingeloggt ist, indem geprüft wird, ob der Benutzername in der Session gespeichert ist
if (!isset($_SESSION["username"])) {
    // Wenn der Benutzer nicht eingeloggt ist, wird er zur Login-Seite weitergeleitet
    header("Location: index.php");
    exit; // Beendet das Skript, um sicherzustellen, dass kein weiterer Code ausgeführt wird
}

// Stellt die Verbindung zur Datenbank her, indem eine externe Datei eingebunden wird
require_once('mysql-vokabel.php');

// Prüft, ob eine Löschaktion angefordert wurde
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id']; // Ruft die ID der zu löschenden Vokabel aus der URL ab
    $stmt = $mysql->prepare("DELETE FROM Vokabeln WHERE id = :id"); // Bereitet das SQL-Statement zum Löschen vor
    $stmt->execute([':id' => $delete_id]); // Führt die Abfrage aus und ersetzt :id mit der tatsächlichen ID
    header("Location: vokabeln-verwalten.php"); // Leitet zurück zur Verwaltungsseite, um die Änderungen anzuzeigen
    exit(); // Beendet das Skript nach der Weiterleitung
}

// Holt alle Vokabeln aus der Datenbank, um sie in der Tabelle anzuzeigen
$stmt = $mysql->query("SELECT * FROM Vokabeln"); // Führt eine SQL-Abfrage aus, um alle Vokabeln abzurufen
$vokabeln = $stmt->fetchAll(PDO::FETCH_ASSOC); // Speichert die Ergebnisse als assoziatives Array
?>


<!DOCTYPE html>
<html lang="de">
<head>
    <!-- Metadaten und Bootstrap-Integration -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vokabeln verwalten</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"> <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css"> <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="vokabel-verwalten.css"> <!-- Externe CSS-Datei für eigenes Styling -->
</head>
<body class="bg-light"> <!-- Heller Hintergrund für die Seite -->

<div class="container">
    <div class="table-container">
        <!-- Überschrift -->
        <h2>Meine Vokabeln</h2>

        <!-- Tabelle zur Anzeige der Vokabeln -->
        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <!-- Tabellenüberschriften -->
                    <th>Deutsches Wort</th>
                    <th>Englisches Wort</th>
                    <th style="width: 50px;">Löschen</th> <!-- Spalte für das Löschen-Symbol -->
                </tr>
            </thead>
            <tbody>
                <!-- Schleife, die durch alle Vokabeln iteriert und sie in die Tabelle einfügt -->
                <?php foreach ($vokabeln as $vokabel): ?>
                    <tr>
                        <!-- Zeigt das deutsche Wort -->
                        <td><?php echo htmlspecialchars($vokabel['deutsches_Wort']); ?></td>
                        <!-- Zeigt das englische Wort -->
                        <td><?php echo htmlspecialchars($vokabel['englisches_Wort']); ?></td>
                        <!-- Löschen-Button mit Mülleimer-Icon -->
                        <td class="text-center">
                            <a href="vokabeln-verwalten.php?delete_id=<?php echo $vokabel['id']; ?>" class="delete-icon">
                                <i class="bi bi-trash"></i> <!-- Bootstrap-Mülleimer-Icon -->
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?> <!-- Ende der Schleife -->
            </tbody>
        </table>

        <!-- Buttons für Aktionen -->
        <div class="button-container">
            <!-- Button zum Hinzufügen einer neuen Vokabel -->
            <a href="vokabel-hinzufuegen.php" class="btn btn-lila">Vokabeln hinzufügen</a>
            <!-- Button zur Rückkehr zur Startseite -->
            <a href="startseite.php" class="btn btn-secondary">Zurück zur Startseite</a>
        </div>
    </div>
</div>

</body>
</html>

