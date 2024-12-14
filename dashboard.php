<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}
?>
<h1>Selamat Datang, <?= htmlspecialchars($_SESSION['full_name']); ?>!</h1>
<a href="logout.php">Logout</a>
