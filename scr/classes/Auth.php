<?php
namespace cbr\classes;

use PDO;
class Auth
{
    private $db;
    public function __construct($db)
    {
        $this->db = $db;
    }
    public function login($username, $password)
    {
        $query = "SELECT * FROM users where username = :username";
        $statement = $this->db->prepare($query);
        $statement->bindValue(':username', $username);
        $statement->execute();
        $user = $statement->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            if (password_verify($password, $user['password'])) {
                return true;
            }
        }
        return false;
    }
}
?>