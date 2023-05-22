<!-- Här ska external API finnas --> 

<?php

// Check for a defined constant or specific file inclusion
if (!defined('MY_APP') && basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
    die('This file cannot be accessed directly.');
}

// https://github.com/fawazahmed0/currency-api#readme
class ExchangeRateFetcher {
    private $base_url = "https://cdn.jsdelivr.net/gh/fawazahmed0/currency-api@1/latest/";
    
    // Fetches all available currencies from the API
    function fetchCurrencies(){
        // Construct the URL for the API request using the base URL
        $url = $this->base_url . "currencies.json";
      
        // Fetch the data from the API using the constructed URL
        $data = file_get_contents($url);
      
        // Decode the JSON data
        // The "true" argument to json_decode returns an associative array instead of an object
        $currencies = json_decode($data, true);
      
        // Return the currency codes to the caller
        return $currencies;
    }

    // Fetches the exchange rate for the specified currency pair
    function fetchExchangeRate($from_currency, $to_currency) {

        // Construct the URL for the API request using the base URL and currency codes
        $url = "{$this->base_url}currencies/{$from_currency}/{$to_currency}.json";
      
        // Fetch the data from the API using the constructed URL
        $data = file_get_contents($url);
      
        // Decode the JSON data and extract the exchange rate value
        // The "true" argument to json_decode returns an associative array instead of an object
        // The [$to_currency] index selects the property of the decoded data, which contains the exchange rate
        $response = json_decode($data, true);
        $exchange_rate = $response[$to_currency];
      
        // Return the exchange rate value to the caller
        return $exchange_rate;
      }
  }