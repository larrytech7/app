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

    //initialize platform charges
    public function __construct($amount, $currency, $destinationProvider){
        $this->currency = $currency;
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
        if($originProvider == 'ew' && $destProvider == 'pp')
            return $this->getDueAmountForEwayToPayPal();
        else if($originProvider == 'ew' && $destProvider == 'stp')
            return $this->getDueAmountForEwayToStp();
        else if($originProvider == 'ew' && $destProvider == 'sk' )
            return $this->getDueAmountForEwayToSkrill();
        else if($originProvider == 'pp' && $destProvider == 'mm')
            return $this->getDueAmountForPayPalToMobileMoney();
        else if($originProvider == 'pp' && $destProvider ==  'ew')
            return $this->getDueAmountForPayPalToEway();
        else if($originProvider == 'pp' && $destProvider ==  'sk')
            return $this->getDueAmountForPayPalToSkrill();
        else if($originProvider == 'pp' && $destProvider ==  'stp')
            return $this->getDueAmountForPayPalToStp();
        else if($originProvider == 'mm' && $destProvider ==  'ew')
            return $this->getDueAmountForMobileMoneyToEway();
        else if($originProvider == 'mm' && $destProvider ==  'pp')
            return $this->getDueAmountForMobileMoneyToPayPal();
        else if($originProvider == 'mm' && $destProvider ==  'sk')
            return $this->getDueAmountForMobileMoneyToSkrill();
        else if($originProvider == 'stp' && $destProvider ==  'ew')
            return 0; //TODO:
        else
            return 0;    
    }
    //TODO:: Tarrifs here need to be revised and match the actual charge tarrifs
    //apply paypal to mobile money charges
    private function getDueAmountForPayPalToMobileMoney(){
            
                if($this->amount >= 5.0 && $this->amount <= 10.0 ){ //free of charge
                    return $this->amount ;    
                }else if($this->amount > 10.0 && $this->amount <= 20.0 ){ //
                    return $this->amount + (0.01 * $this->amount);    
                }else if($this->amount > 20.0 && $this->amount <= 50.0 ){ //
                    return $this->amount + (0.03 * $this->amount);    
                }else if($this->amount > 50.0 && $this->amount <= 100.0 ){ //
                    return $this->amount + (0.05 * $this->amount);    
                }else if($this->amount > 100.0 && $this->amount <= 200.0 ){ //
                    return $this->amount + (0.08 * $this->amount);   
                }else if($this->amount > 200.0 && $this->amount <= 500.0 ){ //
                    return $this->amount + (0.15 * $this->amount);    
                }else{
                    return $this->amount + (0.20 * $this->amount) ; //charge 1/8 of the transfer sum
                }
    }
    
    //apply eway to STP charges
    private function getDueAmountForEwayToStp(){
            
                if($this->amount >= 5.0 && $this->amount <= 10.0 ){ //free of charge
                    return $this->amount ;    
                }else if($this->amount > 10.0 && $this->amount <= 20.0 ){ //
                    return $this->amount + (0.01 * $this->amount);    
                }else if($this->amount > 20.0 && $this->amount <= 50.0 ){ //
                    return $this->amount + (0.03 * $this->amount);    
                }else if($this->amount > 50.0 && $this->amount <= 100.0 ){ //
                    return $this->amount + (0.05 * $this->amount);    
                }else if($this->amount > 100.0 && $this->amount <= 200.0 ){ //
                    return $this->amount + (0.08 * $this->amount);   
                }else if($this->amount > 200.0 && $this->amount <= 500.0 ){ //
                    return $this->amount + (0.15 * $this->amount);    
                }else{
                    return $this->amount + (0.20 * $this->amount) ; //charge 1/8 of the transfer sum
                }
    }
    
    //apply eway to mobile money charges
    private function getDueAmountForEwayToMobileMoney(){
            
                if($this->amount >= 5.0 && $this->amount <= 10.0 ){ //free of charge
                    return $this->amount ;    
                }else if($this->amount > 10.0 && $this->amount <= 20.0 ){ //
                    return $this->amount + (0.01 * $this->amount);    
                }else if($this->amount > 20.0 && $this->amount <= 50.0 ){ //
                    return $this->amount + (0.03 * $this->amount);    
                }else if($this->amount > 50.0 && $this->amount <= 100.0 ){ //
                    return $this->amount + (0.05 * $this->amount);    
                }else if($this->amount > 100.0 && $this->amount <= 200.0 ){ //
                    return $this->amount + (0.08 * $this->amount);   
                }else if($this->amount > 200.0 && $this->amount <= 500.0 ){ //
                    return $this->amount + (0.15 * $this->amount);    
                }else{
                    return $this->amount + (0.20 * $this->amount) ; //charge 1/8 of the transfer sum
                }
    }
    
    //apply eway to Skrill charges
    private function getDueAmountForEwayToSkrill(){
            
                if($this->amount >= 5.0 && $this->amount <= 10.0 ){ //free of charge
                    return $this->amount ;    
                }else if($this->amount > 10.0 && $this->amount <= 20.0 ){ //
                    return $this->amount + (0.01 * $this->amount);    
                }else if($this->amount > 20.0 && $this->amount <= 50.0 ){ //
                    return $this->amount + (0.03 * $this->amount);    
                }else if($this->amount > 50.0 && $this->amount <= 100.0 ){ //
                    return $this->amount + (0.05 * $this->amount);    
                }else if($this->amount > 100.0 && $this->amount <= 200.0 ){ //
                    return $this->amount + (0.08 * $this->amount);   
                }else if($this->amount > 200.0 && $this->amount <= 500.0 ){ //
                    return $this->amount + (0.15 * $this->amount);    
                }else{
                    return $this->amount + (0.20 * $this->amount) ; //charge 1/8 of the transfer sum
                }
    }
    //apply eway to paypal charges
    private function getDueAmountForEwayToPayPal(){
            
                if($this->amount >= 5.0 && $this->amount <= 10.0 ){ //free of charge
                    return $this->amount ;    
                }else if($this->amount > 10.0 && $this->amount <= 20.0 ){ //
                    return $this->amount + (0.01 * $this->amount);    
                }else if($this->amount > 20.0 && $this->amount <= 50.0 ){ //
                    return $this->amount + (0.03 * $this->amount);    
                }else if($this->amount > 50.0 && $this->amount <= 100.0 ){ //
                    return $this->amount + (0.05 * $this->amount);    
                }else if($this->amount > 100.0 && $this->amount <= 200.0 ){ //
                    return $this->amount + (0.08 * $this->amount);   
                }else if($this->amount > 200.0 && $this->amount <= 500.0 ){ //
                    return $this->amount + (0.15 * $this->amount);    
                }else{
                    return $this->amount + (0.20 * $this->amount) ; //charge 1/8 of the transfer sum
                }
    }
    
    //apply charges when sending from Paypal to Eway
    private function getDueAmountForPayPalToEway(){
            
                if($this->amount >= 5.0 && $this->amount <= 10.0 ){ //free of charge
                    return $this->amount ;    
                }else if($this->amount > 10.0 && $this->amount <= 20.0 ){ //
                    return $this->amount + (0.01 * $this->amount);    
                }else if($this->amount > 20.0 && $this->amount <= 50.0 ){ //
                    return $this->amount + (0.03 * $this->amount);    
                }else if($this->amount > 50.0 && $this->amount <= 100.0 ){ //
                    return $this->amount + (0.05 * $this->amount);    
                }else if($this->amount > 100.0 && $this->amount <= 200.0 ){ //
                    return $this->amount + (0.08 * $this->amount);   
                }else if($this->amount > 200.0 && $this->amount <= 500.0 ){ //
                    return $this->amount + (0.15 * $this->amount);    
                }else{
                    return $this->amount + (0.20 * $this->amount) ; //charge 1/8 of the transfer sum
                }
    }
    
    //apply charges when sending from Paypal to STP
    private function getDueAmountForPayPalToStp(){
            
                if($this->amount >= 5.0 && $this->amount <= 10.0 ){ //free of charge
                    return $this->amount ;    
                }else if($this->amount > 10.0 && $this->amount <= 20.0 ){ //
                    return $this->amount + (0.01 * $this->amount);    
                }else if($this->amount > 20.0 && $this->amount <= 50.0 ){ //
                    return $this->amount + (0.03 * $this->amount);    
                }else if($this->amount > 50.0 && $this->amount <= 100.0 ){ //
                    return $this->amount + (0.05 * $this->amount);    
                }else if($this->amount > 100.0 && $this->amount <= 200.0 ){ //
                    return $this->amount + (0.08 * $this->amount);   
                }else if($this->amount > 200.0 && $this->amount <= 500.0 ){ //
                    return $this->amount + (0.15 * $this->amount);    
                }else{
                    return $this->amount + (0.20 * $this->amount) ; //charge 1/8 of the transfer sum
                }
    }
    
    //apply charges when sending from Paypal to Skrill
    private function getDueAmountForPayPalToSkrill(){
            
                if($this->amount >= 5.0 && $this->amount <= 10.0 ){ //free of charge
                    return $this->amount ;    
                }else if($this->amount > 10.0 && $this->amount <= 20.0 ){ //
                    return $this->amount + (0.01 * $this->amount);    
                }else if($this->amount > 20.0 && $this->amount <= 50.0 ){ //
                    return $this->amount + (0.03 * $this->amount);    
                }else if($this->amount > 50.0 && $this->amount <= 100.0 ){ //
                    return $this->amount + (0.05 * $this->amount);    
                }else if($this->amount > 100.0 && $this->amount <= 200.0 ){ //
                    return $this->amount + (0.08 * $this->amount);   
                }else if($this->amount > 200.0 && $this->amount <= 500.0 ){ //
                    return $this->amount + (0.15 * $this->amount);    
                }else{
                    return $this->amount + (0.20 * $this->amount) ; //charge 1/8 of the transfer sum
                }
    } 

    //apply charges for transfers from mobile money to paypal
    private function getDueAmountForMobileMoneyToPayPal(){
        return 0;
    }
    
    //apply charges for transfers from mobile money to paypal
    private function getDueAmountForMobileMoneyToSkrill(){
        return 0;
    }
    
    //apply charges for transfers from mobile money to paypal
    private function getDueAmountForMobileMoneyToEway(){
        return 0;
    }
    


    public function convertCurrency($fromCurrency, $toCurrency, $amount){
         if($fromCurrency == $toCurrency ){
                return $amount;
            }

         if($fromCurrency == 'USD' && $toCurrency == 'EUR'){
               return $amount * 0.90 ;
            }else if($fromCurrency == 'EUR' && $toCurrency == 'USD'){
                return $amount / 0.90 ;
                
            }else if($fromCurrency == 'GBP' && $toCurrency == 'USD'){
                return $amount * 1.51 ;
            
            }else if($fromCurrency == 'USD' && $toCurrency == 'GBP'){
                return $amount / 1.51 ;
            
            }else if($fromCurrency == 'XAF' && $toCurrency == 'USD'){
                return $amount / 588.86 ;
            
            }else if($fromCurrency == 'USD' && $toCurrency == 'XAF'){
                return $amount * 588.86 ;
            
            }else if($fromCurrency == 'EUR' && $toCurrency == 'XAF'){
                return $amount / 655.66 ;
            }
            else
                return $amount;
    }

}