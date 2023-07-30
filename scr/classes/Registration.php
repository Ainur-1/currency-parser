<?php

namespace cbr\classes;

class Registration
{
    private $db;
    public function __construct($db)
    {
        $this->db = $db;
    }
    public function registerUser($username, $password)
    {
        // Проверка существования пользователя
        if ($this->userExists($username)) {
            return false;
        }
        // Хеширование пароля
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $query = "INSERT INTO users (username, password) VALUES (:username, :password)";
        $statement = $this->db->prepare($query);
        $statement->bindParam(':username', $username);
        $statement->bindParam(':password', $hashedPassword);

        // Проверка успешности забписи в БД
        if ($statement->execute()) {
            return true;
        } else {
            return false;
        }
    }
    private function userExists($username)
    {
        // Проверка существования пользователя в базе данных
        $query = "SELECT * FROM users WHERE username = :username";
        $statement = $this->db->prepare($query);
        $statement->bindParam(':username', $username);
        $statement->execute();

        return $statement->rowCount() > 0;
    }

}
?>