<?php 
$dsn = 'pgsql:host=localhost;dbname=postgres';
$username = 'postgres';
$password = 'poledu76';
try {
    $db = new PDO($dsn, $username, $password);
} catch (PDOException $e) {
    echo 'Ошибка подключения к базе данных: ' . $e->getMessage();
    exit();
}
?>