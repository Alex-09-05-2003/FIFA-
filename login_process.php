<?php
session_start();
require 'db.php';  

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);


    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user["password_hash"])) {
    
        $_SESSION["user"] = $user["username"];
        $_SESSION["user_id"] = $user["id"];

        
        $stmt = $pdo->prepare("SELECT achievement_name FROM achievements WHERE user_id = ? AND is_completed = 1");
        $stmt->execute([$user["id"]]);
        $_SESSION["achievements"] = array_column($stmt->fetchAll(), "achievement_name");

        
        header("Location: welcome.php"); 
        exit();
    } else {
        echo "<script>alert('Username sau parolă incorecte!'); window.location.href='hello.php';</script>";
    }
}

$stmt = $pdo->prepare("SELECT achievement_name FROM achievements WHERE user_id = ? AND is_completed = 1");
$stmt->execute([$user["id"]]);
$_SESSION["achievements"] = array_column($stmt->fetchAll(), "achievement_name");

?>
