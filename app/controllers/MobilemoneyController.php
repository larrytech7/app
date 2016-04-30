<?php
/**
 * @author Larry Akah
 * @date date("Y-m-d")
 * This is the MOBILE MONEY Controller for handling and controlling MM operations
 */  
class MobilemoneyController extends BaseController {

	/**
	 * Make a MM payment to the destined user from the main business account.
	 *
	 * @return void
	 */
	public function requestPayment()
	{
	   //parameters fetched from ajax request
       
	    $AccountID = 4420274;
        $Phonenumber = Input::get('to'); //number of the person who initiated the request
        $Amount = Input::get('amount'); //amount to charge the sender
        $destination = Input::get('receivercontact'); //other address of the receiver
        $dest_provider = Input::get('provider'); //provider platform to send the funds in
        $currency = Input::get('currency'); //currency to use
        $sendto = Input::get('receiver'); //funds are sent to this user
        
        $Amount = $Amount + ((2/100) * $Amount);
        
        $mes_donnees = array('MyAccountID'=> $AccountID, 'CustomerPhonenumber' => $Phonenumber, 'Amount' => $Amount);
        
        $postdata = http_build_query($mes_donnees);
        
        $opts = array('http' =>
                    array(
                               'method'  => 'GET',
                               'header'  => 'Content-type: text/xml',
                               'CharSet' => 'utf-8',
                               'content' => $postdata
                        )
        );
        
        $context = stream_context_create($opts);
        $UssdResult = file_get_contents('http://api.furthermarket.com/FM/MTN/MoMo/requestpayment?MyaccountID='.$AccountID
                                        .'&CustomerPhonenumber='.$Phonenumber
                                        .'&Amount='.$Amount
                                        .'&ItemDesignation=MoMoPayment&ItemDescription=SendMomoto_'.$dest_provider.'_user',
                                         1, $context);
        
        header('Content-Type:text/javascript');
        
        echo json_encode(
                    array('paymentresult' => nl2br($UssdResult))
            );
        
	}
    /**
     * handle payment notifications from MM API server
     * 
     */ 
     public function makePayment(){
        
        
     }
     /**
      * Check for payment status
      */ 
      public function checkPayment(){
        
                $AccountID   = Input::get('receiver');
                $PaymentID = Input::get('paymentID');
                $mes_donnees =   array('accountID'  => $AccountID, 'paymentID' => $PaymentID);
        
                $postdata = http_build_query($mes_donnees);
        
                $opts = array('http' =>
                                array(
                                           'method'  => 'GET',
        
                                           'header'  => 'Content-type: text/xml',
        
                                           'CharSet' => 'utf-8',
 
                                           'content' => $postdata
                            )
                    );
        
                    $context       = stream_context_create($opts);
        
                    $UssdResult = file_get_contents('http://api.furthermarket.com/FM/MTN/MoMo/checkpayment?accountID='.$AccountID.'&paymentID='.$PaymentID);
        
                    header('Content-Type:text/javascript');
        
                echo json_encode(
                        array('checkpayment' => nl2br($UssdResult))
                );
      }
      /**
       * 
       */
       public function cancelTransaction(){
            return Redirect::route('dashboard')
			             	->with('alertError', 'Mobile Money Transaction cancelled by user');
       } 

}
