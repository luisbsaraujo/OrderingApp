<?php

//This class gets latest exchange rate in the real world from https://exchangeratesapi.io API
class WebServiceExchangeRates {

  //code of the currency (i.e. USD, BRL, COP, GBP, INR ...)
  static public $currency;

  //get rate
  static public function getExchangeRate() : float {
    try{
      //calls the webService 
      $forex_json = file_get_contents(WEB_SERVICE_URL.self::$currency);

      if (!$forex_json){
        throw new Exception('Error trying Web Service for currency('.self::$currency.').');
      }

      //recieves the result and decode it generating an array
      $forex_array = json_decode($forex_json, true);

      //return result rate
      return $forex_array['rates'][self::$currency];
      
    } catch (Exception $ex) {
        $date = new DateTime();
        error_log(PHP_EOL.$date->format("Ymd H:i:s").': '.$ex->getMessage(), 3, LOG_FILE);
        return false;
    }
  }

}

?>