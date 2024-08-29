<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GAMEREVV</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/Game_web/css/styles.css">
</head>
<body>
    <nav class="navbar">
        <div class="logo">
            <a href="/Game_web/index.php">GAMEREVV</a>
        </div>
        <div class="nav-links">
            <ul>
                <li><a href="/Game_web/index.php">HOME</a></li>
                <li><a href="/Game_web/pages/games.php">GAMES</a></li>
                <li><a href="/Game_web/pages/review.php">REVIEWS</a></li>
                <li><a href="/Game_web/pages/about.php">ABOUT</a></li>
            </ul>
        </div>
        <div class="auth-links">
            <?php if (isset($_SESSION['username'])): ?>
                <a href="/Game_web/pages/review.php">Review</a>
                <a href="/Game_web/logout.php">Logout</a>
            <?php else: ?>
                <a href="/Game_web/pages/login.php">Login</a>
                <a href="/Game_web/pages/signup.php">Signup</a>
            <?php endif; ?>
        </div>
        <div class="hamburger">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </nav>
