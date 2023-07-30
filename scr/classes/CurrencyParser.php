<?php
namespace cbr\classes;

class CurrencyParser
{
    private $db;
    public function __construct($db)
    {
        $this->db = $db;
    }
    private function cleanCurrencies()
    {
        $statement = $this->db->prepare('TRUNCATE TABLE currency_rates RESTART IDENTITY;');
        $statement->execute();
        $statement = $this->db->prepare("INSERT INTO currency_rates (currency_code, rate) VALUES ('RUB', 1);");
        $statement->execute();
    }

    public function parseAndSaveCurrencies()
    {
        $this->cleanCurrencies();
        $xml = simplexml_load_file('https://www.cbr.ru/scripts/XML_daily.asp');

        $success = true;

        foreach ($xml->Valute as $valute) {
            $currencyCode = (string) $valute->CharCode;
            $rate = (float) str_replace(',', '.', (string) $valute->Value);

            $query = 'INSERT INTO currency_rates (currency_code, rate) VALUES (:currencyCode, :rate)';
            $statement = $this->db->prepare($query);
            $statement->bindParam(':currencyCode', $currencyCode);
            $statement->bindParam(':rate', $rate);

            if (!$statement->execute()) {
                $success = false;
            }
        }

        return $success; 
    }
}
?>