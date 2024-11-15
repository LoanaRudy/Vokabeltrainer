<?php
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: index.php");
    exit;
}
require_once('mysql-vokabel.php');

if (!isset($_SESSION['test_started'])) {
    $stmt = $mysql->query("SELECT * FROM Vokabeln");
    $_SESSION['vokabeln'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $_SESSION['test_started'] = true;
    $_SESSION['current_question'] = 0;
    $_SESSION['score'] = 0;
}

if (isset($_POST['cancel_test'])) {
    unset($_SESSION['test_started']);
    header("Location: startseite.php");
    exit();
}

if (isset($_POST['submit_answer'])) {
    $user_answer = trim($_POST['user_answer']);
    $correct_answer = trim($_SESSION['vokabeln'][$_SESSION['current_question']]['englisches_Wort']);

    if (strcasecmp($user_answer, $correct_answer) == 0) {
        $_SESSION['score']++;
        $response = "Richtig!";
        $response_class = 'success';
    } else {
        $response = "Falsch! Die richtige Antwort wäre: " . $correct_answer;
        $response_class = 'danger';
    }

    $_SESSION['current_question']++;

    if ($_SESSION['current_question'] >= count($_SESSION['vokabeln'])) {
        header("Location: endseite.php");
        exit();
    }
}

$current_question = $_SESSION['current_question'];
$vokabel = $_SESSION['vokabeln'][$current_question];
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Vokabeltest</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <script src="https://code.responsivevoice.org/responsivevoice.js"></script>
    <style>
        .btn-lila { background-color: #D8A7E4; color: black; padding: 10px 20px; font-size: 16px; }
        .btn-lila:hover { background-color: #C18ED3; }
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
        .container { display: flex; justify-content: center; align-items: center; min-height: 100vh; padding: 20px; }
        .form-container { width: 100%; max-width: 500px; padding: 20px; background-color: #fff; border: 1px solid #ccc; border-radius: 8px; }
        h2, h3, p { color: black; }
        .button-container { display: flex; gap: 15px; justify-content: flex-start; margin-top: 20px; }
        .input-group { display: flex; align-items: center; gap: 5px; }
        .input-group .form-control { flex: 1; }
        .microphone-button { background-color: #D8A7E4; border: none; color: black; cursor: pointer; padding: 8px 12px; border-radius: 5px; }
        .microphone-button:hover { background-color: #C18ED3; }
    </style>
    <script>
        function speakUserInput() {
            const userInput = document.querySelector('input[name="user_answer"]').value;
            if (userInput) {
                responsiveVoice.speak(userInput, "US English Male");
            } else {
                alert("Bitte gib ein Wort ein, das vorgelesen werden soll.");
            }
        }
    </script>
</head>
<body class="bg-light">

<div class="container">
    <div class="form-container">
        <h2>Vokabeltest</h2>
        <p>Übersetze das Wort auf Englisch:</p>
        <h3><?php echo htmlspecialchars($vokabel['deutsches_Wort']); ?></h3>

        <form method="POST" class="d-flex flex-column gap-3">
            <div class="input-group">
                <input type="text" name="user_answer" class="form-control" placeholder="Deine Antwort" required>
                <button type="button" onclick="speakUserInput();" class="microphone-button">
                    <i class="bi bi-mic-fill"></i>
                </button>
            </div>

            <?php if (isset($response)): ?>
                <div class="mt-1 alert alert-<?php echo $response_class; ?>">
                    <?php echo $response; ?>
                </div>
            <?php endif; ?>

            <div class="button-container">
                <form method="POST">
                    <button type="submit" name="submit_answer" class="btn btn-lila">Antwort absenden</button>
                </form>
                <form method="POST">
                    <button type="submit" name="cancel_test" class="btn btn-secondary">Test abbrechen</button>
                </form>
            </div>
        </form>
    </div>
</div>
</body>
</html> 



   



