<?php

$db = __DIR__ . '/../database.sqlite';

$dsn = "sqlite:$db";

try {
    $pdo = new PDO($dsn);
    
    return $pdo;
} catch (PDOException $e) {
        echo "error $e";
}