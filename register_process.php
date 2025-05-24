<?php
require 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);

    
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);

    if ($stmt->fetch()) {
        echo "<script>alert('Utilizatorul există deja!'); window.location.href='register.php';</script>";
    } else {
    
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        
        $stmt = $pdo->prepare("INSERT INTO users (username, password_hash) VALUES (?, ?)");
        $stmt->execute([$username, $hashedPassword]);

        echo "<script>alert('Înregistrare reușită! Te poți autentifica acum.'); window.location.href='hello.php';</script>";
    }
}
?>
