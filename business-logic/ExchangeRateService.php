<?php

// Check for a defined constant or specific file inclusion
if (!defined('MY_APP') && basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
    die('This file cannot be accessed directly.');
}

require_once __DIR__ . "/../currencies-data-access/ExchangeRateFetcher.php";

class ExchangeRateService{

    // Fetches all available currencies from the API
    public static function getCurrencies(){
        $exchange_rate_fetcher = new ExchangeRateFetcher();

        $currencies = $exchange_rate_fetcher->fetchCurrencies();

        return $currencies;
    }

    // Fetches the exchange rate for the specified currency pair
    public static function fetchExchangeRate($from_currency, $to_currency) {
        $exchange_rate_fetcher = new ExchangeRateFetcher();

        $exchange_rate = $exchange_rate_fetcher->fetchExchangeRate($from_currency, $to_currency);

        return $exchange_rate;
    }

    // Converts the specified amount from one currency to another
    public static function convertCurrency($from_currency, $to_currency, $amount) {
        $exchange_rate = self::fetchExchangeRate($from_currency, $to_currency);

        $converted_amount = $amount * $exchange_rate;

        return $converted_amount;
    }
    

    // Converts the specified amount from SEK to the specified currency
    public static function sekToCurrency($to_currency, $amount) {
        $converted_amount = self::convertCurrency("sek", $to_currency, $amount);

        return $converted_amount;
    }

    // Converts the specified amount from SEK to USD
    public static function sekToUsd($amount) {
        $converted_amount = self::convertCurrency("sek", "usd", $amount);

        return $converted_amount;
    }

    // Converts the specified amount from SEK to EUR
    public static function sekToEur($amount) {
        $converted_amount = self::convertCurrency("sek", "eur", $amount);

        return $converted_amount;
    }


}