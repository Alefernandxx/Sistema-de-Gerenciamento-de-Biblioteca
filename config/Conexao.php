<?php
declare(strict_types=1);

$host = 'localhost';
$dbname = 'biblioteca';
$port = '3306';
$username = 'root';
$password = '';

$pdo = new PDO(
    "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4",
    $username,
    $password,
    [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]
);