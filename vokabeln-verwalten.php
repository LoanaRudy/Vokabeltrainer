<?php
session_start(); 

// Fehlerprotokollierung aktivieren
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Prüfen, ob der Nutzer eingeloggt ist
if (!isset($_SESSION["username"])) {
    header("Location: index.php");
    exit;
}

require_once('mysql-vokabel.php');

// Prüfen, ob eine Vokabel gelöscht werden soll
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $stmt = $mysql->prepare("DELETE FROM Vokabeln WHERE id = :id");
    $stmt->execute([':id' => $delete_id]);
    header("Location: vokabeln-verwalten.php");
    exit();
}

// Alle Vokabeln aus der Datenbank abrufen
$stmt = $mysql->query("SELECT * FROM Vokabeln");
$vokabeln = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vokabeln verwalten</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css"> <!-- Bootstrap Icons -->
    <style>
        .btn-lila {
            background-color: #D8A7E4;
            color: black;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            flex: 1;
        }
        .btn-lila:hover {
            background-color: #C18ED3;
        }
        /* Stil für den Zurück-Button */
        .btn-secondary {
            background-color: #d3d3d3;
            color: black;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            flex: 1;
        }
        .btn-secondary:hover {
            background-color: #b0b0b0; /* Etwas dunkleres Grau beim Hover */
            color: black; /* Schwarze Schrift bleibt beim Hover */
        }
        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }
        .table-container {
            width: 100%;
            max-width: 800px;
            padding: 30px;
            border: 1px solid #ccc;
            border-radius: 8px;
            background-color: #fff;
        }
        .button-container {
            display: flex;
            gap: 15px;
            justify-content: flex-end;
            margin-top: 20px;
        }
        h1, h2 {
            color: black;
            text-align: center;
        }
        /* Stil für das Mülleimer-Icon */
        .delete-icon {
            color: gray;
            font-size: 20px;
            text-decoration: none;
            cursor: pointer;
        }
        .delete-icon:hover {
            color: #dc3545; /* Rot bei Hover */
        }
    </style>
</head>
<body class="bg-light">

<div class="container">
    <div class="table-container">
        <h2>Meine Vokabeln</h2>

        <!-- Tabelle der Vokabeln -->
        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>Deutsches Wort</th>
                    <th>Englisches Wort</th>
                    <th style="width: 50px;">Löschen</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($vokabeln as $vokabel): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($vokabel['deutsches_Wort']); ?></td>
                        <td><?php echo htmlspecialchars($vokabel['englisches_Wort']); ?></td>
                        <td class="text-center">
                            <a href="vokabeln-verwalten.php?delete_id=<?php echo $vokabel['id']; ?>" class="delete-icon">
                                <i class="bi bi-trash"></i> <!-- Mülleimer-Icon -->
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Buttons für weitere Aktionen -->
        <div class="button-container">
            <a href="vokabel-hinzufuegen.php" class="btn btn-lila">Vokabeln hinzufügen</a>
            <a href="startseite.php" class="btn btn-secondary">Zurück zur Startseite</a>
        </div>
    </div>
</div>

</body>
</html>