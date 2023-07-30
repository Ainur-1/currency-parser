<?php
require_once '../../vendor/autoload.php';
require_once '../database_connection.php';

use cbr\classes\Auth;
use cbr\classes\Registration;

$auth = new Auth($db);
$registration = new Registration($db);

$username = "";
$password = "";
$entryType = "";

if (isset($_POST["username"])) {

    $username = $_POST["username"];
}

if (isset($_POST["password"])) {

    $password = $_POST["password"];
}

if (isset($_POST["entryType"])) {

    $entryType = $_POST["entryType"];
}

if ($entryType == "Войти") {
    if ($auth->login($username, $password)) {
        header('Location: profile.php');
    } else {
        echo 'Пользователь не найден.';
    }
}

if ($entryType == "Регистрация") {
    if ($registration->registerUser($username, $password)) {
        echo 'Вы успешно зарегистрировались! Теперь можете войти, используя свои данные.';
    } else {
        echo 'Ошибка регистрации.';
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset=utf-8>
    <title>Вход</title>
    <style>
        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            flex-direction: column;
        }

        form {
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Вход</h1>
        <form action="" method="POST">
            <label for="username">Имя пользователя:</label>
            <input type="text" id="username" name="username" required><br> <br>
            <label for="password">Пароль:</label>
            <input type="password" id="password" name="password" required><br> <br>
            <input type="submit" value="Войти" name="entryType"><br> <br>
            <input type="submit" value="Регистрация" name="entryType">
        </form>
    </div>
</body>

</html>