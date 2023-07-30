<?php
require_once '../../vendor/autoload.php';
require_once '../database_connection.php';

use cbr\classes\Converter;

$converter = new Converter($db);
$currencies = $converter->getCurrencies();
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset=utf-8>
    <title>Личный кабинет</title>
    <style>
        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 250vh;
            flex-direction: column;
        }

        form {
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Конвертер валют</h2>
        <form method="POST" action="">
            <label for="amount">Сумма:</label>
            <input type="text" name="amount" required>
            <br><br>
            <label for="from_currency">Из:</label>
            <select name="from_currency">
                <?php foreach ($currencies as $currency) {
                    echo "<option value=\"$currency\">$currency</option>";
                }
                ?>
            </select>
            <br><br>
            <label for="to_currency">В:</label>
            <select name="to_currency">
                <?php foreach ($currencies as $currency) {
                    echo "<option value=\"$currency\">$currency</option>";
                } ?>
            </select>
            <br><br>
            <input type="submit" value="Конвертировать">
        </form>
        <br><br>
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $amount = $_POST["amount"];
            $fromCurrency = $_POST["from_currency"];
            $toCurrency = $_POST["to_currency"];

            if (is_numeric($amount)) {
                if ($amount < 0)
                    echo 'Сумма не может быть отрицательным!';
                else {
                    $convertedAmount = $converter->Convert($amount, $fromCurrency, $toCurrency);
                    echo $amount . ' ' . $fromCurrency . ' = ' . $convertedAmount . ' ' . $toCurrency;
                }
            } else
                echo $amount . ' - не число!';

        }
        ?>
        <?php include('currencies.php') ?>
    </div>
</body>

</html>