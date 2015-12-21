<?php

/**
 * A global class that takes care of utility operations like getting charges for the different payment methods 
 * 
 */
 //TODO:: Add skrill, STP charges methods to the various payment providers
 //all amount is initially converted to USD, the standard upon which transactions are made
  
class PlatformCharges{

    private $currency;
    private $amount;
    private $charge;
    private $destProvider;
    private $ewamount;

    //initialize platform charges
    /**
     * Initialise class
     * @param $amount: The amount to calculate charges upon
     * @param $currency: The sender's currency
     * @param $destinationProvider: The receiver's intended currency
     */ 
    public function __construct($amount, $currency, $destinationProvider){
        $this->currency = $currency;
        $this->ewamount = $amount;
        $this->amount = $this->convertCurrency($currency, 'USD', $amount);
        $this->destProvider = $destinationProvider;
    }
    
    //get human readable text for the different payment provider types
    public function getReceiverType($v){
        if($v == 'pp')
            return 'PayPal';
        else if($v == 'stp')
            return 'Solid Trust Pay';
        else if($v == 'sk' )
            return 'Skrill';
        else if($v == 'mm')
            return 'Mobile Money';
        else if($v ==  'ew')
            return 'Eway';
    }

    //get the amount + applicable charges when sending from one account to another
    /**
     * @param $originProvider: The sender's payment provider
     * @param $destProvider: The recceiver's payment provider
     * @return the total amount(floating point value) to be charged the sender by his payment provider
     */ 
    public function getDueAmount($originProvider, $destProvider){
            //return 5.0;
        if($originProvider == 'ew') //am average charge of $0.5 has to be applied here
            return ( $this->ewamount + (0.01 * $this->ewamount) );
        else if($originProvider == 'pp')
            return $this->amount;//TODO:
        else if($originProvider == 'mm')
            return 0;//TODO:
        else if($originProvider == 'sk')
            return 0; //TODO:
        else if($originProvider == 'stp')
            return 0; //TODO:
        else
            return 0;    
    }
    
    public function convertCurrency($fromCurrency, $toCurrency, $amount){
         if($fromCurrency == $toCurrency ){
                return $amount;
            }

         if($fromCurrency == 'USD' && $toCurrency == 'EUR'){
               return $amount * 0.85 ;
            }else if($fromCurrency == 'EUR' && $toCurrency == 'USD'){
                return $amount / 0.85 ;
                
            }else if($fromCurrency == 'EUR' && $toCurrency == 'XAF'){
                return $amount * 650.00 ;
            }else if($fromCurrency == 'EUR' && $toCurrency == 'ZAR'){
                return $amount * 16.35 ;
            }else if($fromCurrency == 'EUR' && $toCurrency == 'AUD'){
                return $amount * 1.51 ;
            }else if($fromCurrency == 'EUR' && $toCurrency == 'JPY'){
                return $amount * 132.65 ;
            }else if($fromCurrency == 'EUR' && $toCurrency == 'CAD'){
                return $amount * 1.50 ;
            }else if($fromCurrency == 'EUR' && $toCurrency == 'GBP'){
                return $amount * 0.70 ;
            }else if($fromCurrency == 'GBP' && $toCurrency == 'USD'){
                return $amount * 1.40 ;
            
            }else if($fromCurrency == 'GBP' && $toCurrency == 'XAF'){
                return $amount * 810 ;
            
            }else if($fromCurrency == 'GBP' && $toCurrency == 'EUR'){
                return $amount * 1.43 ;
            
            }else if($fromCurrency == 'GBP' && $toCurrency == 'JPY'){
                return $amount * 180.00 ;
            
            }else if($fromCurrency == 'GBP' && $toCurrency == 'AUD'){
                return $amount * 1.55 ;
            
            }else if($fromCurrency == 'GBP' && $toCurrency == 'ZAR'){
                return $amount * 22.00 ;
            
            }else if($fromCurrency == 'GBP' && $toCurrency == 'CAD'){
                return $amount * 1.51 ;
            
            }else if($fromCurrency == 'USD' && $toCurrency == 'GBP'){
                return $amount / 1.40 ;
            
            }else if($fromCurrency == 'USD' && $toCurrency == 'JPY'){
                return $amount * 119.50 ;
            
            }else if($fromCurrency == 'USD' && $toCurrency == 'AUD'){
                return $amount * 1.33 ;
            
            }else if($fromCurrency == 'USD' && $toCurrency == 'CAD'){
                return $amount * 1.31 ;
            
            }else if($fromCurrency == 'USD' && $toCurrency == 'ZAR'){
                return $amount * 14.13 ;
            
            }else if($fromCurrency == 'USD' && $toCurrency == 'XAF'){
                return $amount * 570.00 ;
            
            }else if($fromCurrency == 'XAF' && $toCurrency == 'USD'){
                return $amount / 570.00 ;
            
            }else if($fromCurrency == 'XAF' && $toCurrency == 'GBP'){
                return $amount / 800.50 ;
            
            }else if($fromCurrency == 'XAF' && $toCurrency == 'EUR'){
                return $amount / 650.00 ;
            
            }else if($fromCurrency == 'XAF' && $toCurrency == 'CAD'){
                return $amount * 0.0019 ;
            
            }else if($fromCurrency == 'XAF' && $toCurrency == 'AUD'){
                return $amount * 0.0017 ;
            
            }else if($fromCurrency == 'XAF' && $toCurrency == 'JPY'){
                return $amount * 0.15 ;
            
            }else if($fromCurrency == 'XAF' && $toCurrency == 'ZAR'){
                return $amount * 0.015 ;
            
            }else if($fromCurrency == 'ZAR' && $toCurrency == 'USD'){
                return $amount / 14.13 ;
            
            }else if($fromCurrency == 'ZAR' && $toCurrency == 'EUR'){
                return $amount / 16.35 ;
            
            }else if($fromCurrency == 'ZAR' && $toCurrency == 'GBP'){
                return $amount / 22.00 ;
            
            }else if($fromCurrency == 'ZAR' && $toCurrency == 'CAD'){
                return $amount * 0.08 ;
            
            }else if($fromCurrency == 'ZAR' && $toCurrency == 'AUD'){
                return $amount * 10.5 ;
            
            }else if($fromCurrency == 'ZAR' && $toCurrency == 'XAF'){
                return $amount / 0.015 ;
            
            }else if($fromCurrency == 'ZAR' && $toCurrency == 'JPY'){
                return $amount * 7.80 ;
            
            }else if($fromCurrency == 'AUD' && $toCurrency == 'GBP'){
                return $amount / 1.55 ;
            
            }else if($fromCurrency == 'AUD' && $toCurrency == 'EUR'){
                return $amount / 1.51 ;
            
            }else if($fromCurrency == 'AUD' && $toCurrency == 'USD'){
                return $amount / 1.33 ;
            
            }else if($fromCurrency == 'AUD' && $toCurrency == 'CAD'){
                return $amount * 0.80 ;
            
            }else if($fromCurrency == 'AUD' && $toCurrency == 'XAF'){
                return $amount / 500.00 ;
            
            }else if($fromCurrency == 'AUD' && $toCurrency == 'ZAR'){
                return $amount / 10.50 ;
            
            }else if($fromCurrency == 'AUD' && $toCurrency == 'JPY'){
                return $amount / 85.00 ;
            
            }
            else
                return $amount;
    }

}