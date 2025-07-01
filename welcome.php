<?php
session_start();
require 'db.php';


if (!isset($_SESSION["user"]) || !isset($_SESSION["user_id"])) {
    header("Location: hello.php");
    exit();
}

$userId = $_SESSION["user_id"];


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $selected = $_POST["achievements"] ?? [];

    
    $pdo->prepare("UPDATE achievements SET is_completed = 0 WHERE user_id = ?")->execute([$userId]);

    
    if (!empty($selected)) {
        $stmt = $pdo->prepare("UPDATE achievements SET is_completed = 1 WHERE user_id = ? AND achievement_name = ?");
        foreach ($selected as $achievement) {
            $stmt->execute([$userId, $achievement]);
        }
    }
}


$stmt = $pdo->prepare("SELECT achievement_name FROM achievements WHERE user_id = ? AND is_completed = 1");
$stmt->execute([$userId]);
$achievementsCompleted = array_column($stmt->fetchAll(), 'achievement_name');
?>
<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bine ai venit</title>
    <link rel="stylesheet" href="css/welcome.css">
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="story.php">Story</a></li>
                <li><a href="gallery.php">Gallery</a></li>
                <li><a href="combat.php">Combat</a></li>
            </ul>
        </nav>
    </header>

    <div class="logout-container">
        <a href="logout.php">Logout</a>
    </div>

    <div class="container">
        <div class="news">
            <h2>Noutăți despre Witcher 3</h2>
            <p>Descoperă cele mai recente actualizări și noutăți despre Witcher 3!</p>
            <ul>
                <li>Nou DLC lansat: Blood and Wine</li>
                <li>Eveniment special: Monsters Hunt Week</li>
                <li>Patch 1.32 disponibil pentru bug fixuri și îmbunătățiri de performanță</li>
            </ul>
        </div>

        <div class="achievements">
            <h2>Achievementuri ale utilizatorului</h2>
            <p>Salut, <?php echo $_SESSION["user"]; ?>! Alege realizările tale:</p>

            <form action="welcome.php" method="POST">
                <ul>
                    <li>
                        <label>
                            <input type="checkbox" name="achievements[]" value="Slayer of Monsters"
                                <?php echo in_array('Slayer of Monsters', $achievementsCompleted) ? 'checked' : ''; ?>>
                            Slayer of Monsters (50 monștri înfrânți)
                        </label>
                    </li>
                    <li>
                        <label>
                            <input type="checkbox" name="achievements[]" value="Master of Sword"
                                <?php echo in_array('Master of Sword', $achievementsCompleted) ? 'checked' : ''; ?>>
                            Master of Sword (1000 lovituri perfecte)
                        </label>
                    </li>
                    <li>
                        <label>
                            <input type="checkbox" name="achievements[]" value="Explorer"
                                <?php echo in_array('Explorer', $achievementsCompleted) ? 'checked' : ''; ?>>
                            Explorer (90% din hartă explorată)
                        </label>
                    </li>
                </ul>
                <button type="submit">Salvează realizările</button>
            </form>

            <h3>Realizările tale selectate:</h3>
            <ul>
                <?php
                if (!empty($achievementsCompleted)) {
                    foreach ($achievementsCompleted as $achievement) {
                        echo "<li>$achievement</li>";
                    }
                } else {
                    echo "<li>Nicio realizare selectată.</li>";
                }
                ?>
            </ul>
        </div>
    </div>
</body>
</html>
