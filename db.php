<?php
$host = 'sql311.infinityfree.com';
$port = '3306';
$dbname = 'if0_41902891_portfolio_db';
$username = 'if0_41902891';
$password = '1215381026';

try {
    $pdo = new PDO(
        "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8",
        $username,
        $password
    );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>