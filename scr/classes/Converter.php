<?php

namespace cbr\classes;

use PDO;
class Converter
{
    private $db;
    public function __construct($db)
    {
        $this->db = $db;
    }
    // Получение списка валют из базы данных
    public function getCurrencies()
    {
        $query = 'SELECT currency_code FROM currency_rates';
        $statement = $this->db->prepare($query);
        $statement->execute();
        $currencies = $statement->fetchAll(PDO::FETCH_COLUMN);
        return $currencies;
    }

    public function Convert($amount, $fromCurrency, $toCurrency)
    {
        // Получение курса валют
        $statement = $this->db->prepare("SELECT rate FROM currency_rates WHERE currency_code = ?");
        $statement->execute([$fromCurrency]);
        $fromRate = $statement->fetchColumn();

        $query = $this->db->prepare("SELECT rate FROM currency_rates WHERE currency_code = ?");
        $query->execute([$toCurrency]);
        $toRate = $query->fetchColumn();

        // Конвертация валюты
        $amount = str_replace(' ', '', $amount);
        $convertedAmount = round((float)(round((int) $amount, 4) * round((float) $fromRate, 4) / round((float) $toRate, 4)), 4);
        //echo '(' . $amount . ' * ' . $fromRate . ') / ' . $toRate . ' = ' . $convertedAmount;

        return $convertedAmount;
    }
}
?>