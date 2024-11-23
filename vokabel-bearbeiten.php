<?php
// Startet die Session
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

// Initialisiert Variablen
$message = "";
$vokabel = null;

// Überprüft, ob die ID der Vokabel übergeben wurde
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Holt die bestehende Vokabel aus der Datenbank
    $stmt = $mysql->prepare("SELECT * FROM Vokabeln WHERE id = :id");
    $stmt->execute([':id' => $id]);
    $vokabel = $stmt->fetch(PDO::FETCH_ASSOC);

    // Falls keine Vokabel gefunden wurde, zurück zur Verwaltungsseite
    if (!$vokabel) {
        header("Location: vokabeln-verwalten.php");
        exit();
    }
}

// Überprüft, ob das Formular abgesendet wurde
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $deutsches_wort = trim($_POST['deutsches_wort']);
    $englisches_wort = trim($_POST['englisches_wort']);

    // Validiert die Eingabefelder
    if (!empty($deutsches_wort) && !empty($englisches_wort)) {
        try {
            // Aktualisiert die Vokabel in der Datenbank
            $stmt = $mysql->prepare("UPDATE Vokabeln SET deutsches_Wort = :deutsch, englisches_Wort = :englisch WHERE id = :id");
            $stmt->execute([
                ':deutsch' => $deutsches_wort,
                ':englisch' => $englisches_wort,
                ':id' => $id
            ]);

            $message = "Vokabel erfolgreich aktualisiert!";
        } catch (PDOException $e) {
            $message = "Fehler beim Aktualisieren der Vokabel: " . $e->getMessage();
        }
    } else {
        $message = "Bitte füllen Sie beide Felder aus.";
    }
}
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vokabel bearbeiten</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="vokabel-bearbeiten.css">

</head>
<body>
<div class="container">
    <div class="form-container">
        <h2>Vokabel bearbeiten</h2>

        <!-- Formular zum Bearbeiten der Vokabel -->
        <form method="POST" action="vokabel-bearbeiten.php?id=<?php echo $id; ?>">
            <div class="mb-3">
                <label for="deutsches_wort" class="form-label">Deutsches Wort</label>
                <input type="text" class="form-control" id="deutsches_wort" name="deutsches_wort"
                       value="<?php echo htmlspecialchars($vokabel['deutsches_Wort']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="englisches_wort" class="form-label">Englisches Wort</label>
                <input type="text" class="form-control" id="englisches_wort" name="englisches_wort"
                       value="<?php echo htmlspecialchars($vokabel['englisches_Wort']); ?>" required>
            </div>

            <!-- Erfolgsmeldung wird hier nach den Eingabefeldern angezeigt -->
            <?php if (!empty($message)): ?>
                <div class="alert alert-success mt-3">
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>

            <button type="submit" class="btn btn-primary">Änderungen speichern</button>
            <a href="vokabeln-verwalten.php" class="btn btn-secondary">Zurück</a>
        </form>
    </div>
</div>
</body>
</html>

