<?php
require_once '../../vendor/autoload.php';
require_once '../database_connection.php';

$query = "SELECT * FROM currency_rates";
$result = $db->query($query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Курсы валют</title>
    <style>
        table {
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            padding: 5px;
        }
    </style>
</head>
<body>
    <h1>Курсы валют</h1>
    <table>
        <tr>
            <th>ID</th>
            <th>Код валюты</th>
            <th>Курс</th>
            <th>Время получения</th>
        </tr>

        <?php
        // Цикл для вывода данных
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>
                    <td>".$row['id']."</td>
                    <td>".$row['currency_code']."</td>
                    <td>".$row['rate']."</td>
                    <td>".$row['updated_at']."</td>
                  </tr>";
        }
        ?>

    </table>
</body>
</html>