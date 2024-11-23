<?php
// Startet die PHP-Session
session_start();

// Aktiviert die Fehleranzeige
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Überprüft, ob der Benutzer eingeloggt ist
if (!isset($_SESSION["username"])) {
    header("Location: index.php");
    exit;
}

// Stellt die Verbindung zur Datenbank her
require_once('mysql-vokabel.php');

// Prüft, ob eine Löschaktion angefordert wurde
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $stmt = $mysql->prepare("DELETE FROM Vokabeln WHERE id = :id");
    $stmt->execute([':id' => $delete_id]);
    header("Location: vokabeln-verwalten.php");
    exit();
}

// Holt alle Vokabeln aus der Datenbank
$stmt = $mysql->query("SELECT * FROM Vokabeln");
$vokabeln = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vokabeln verwalten</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <!-- Eigene CSS-Datei -->
    <link rel="stylesheet" href="vokabeln-verwalten.css">
</head>
<body class="bg-light">
<div class="container">
    <div class="table-container">
        <h2>Meine Vokabeln</h2>

        <!-- Tabelle zur Anzeige der Vokabeln -->
        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>Deutsches Wort</th>
                    <th>Englisches Wort</th>
                    <th style="width: 100px;">Aktionen</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($vokabeln as $vokabel): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($vokabel['deutsches_Wort']); ?></td>
                        <td><?php echo htmlspecialchars($vokabel['englisches_Wort']); ?></td>
                        <td class="text-center">
                            <!-- Bearbeiten-Icon -->
                            <a href="vokabel-bearbeiten.php?id=<?php echo $vokabel['id']; ?>" class="edit-icon">
                                <i class="bi bi-pencil"></i> <!-- Stift-Icon -->
                            </a>
                            <!-- Löschen-Icon -->
                            <a href="vokabeln-verwalten.php?delete_id=<?php echo $vokabel['id']; ?>" class="delete-icon">
                                <i class="bi bi-trash"></i> <!-- Mülleimer-Icon -->
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Buttons für zusätzliche Aktionen -->
        <div class="button-container">
            <a href="vokabel-hinzufuegen.php" class="btn btn-lila">Vokabeln hinzufügen</a>
            <a href="startseite.php" class="btn btn-secondary">Zurück zur Startseite</a>
        </div>
    </div>
</div>
</body>
</html>




