<?php
/**
 * @author Larry Akah
 * @date date("Y-m-d")
 * This is the Solid Trust Pay Controller for handling and controlling stp operations
 */  
class StpayController extends BaseController {
    
    public static $_STP_API_PASSWORD = '7z$$}2yY!i.f:!$';
    public static $_STP_API_NAME = 'izepayapp';
    public static $_STP_ACCOUNT_PASS = 'creationFox7!';
    public static $_STP_API_URL = 'https://solidtrustpay.com/accapi/process.php';
    public static $STP_PAY_URL = 'https://solidtrustpay.com/handle_accver.php'; //url for user to send payment to admin account
    public static $_STP_USERNAME = 'larryakah';

	/**
	 * Make a STP payment to the destined user from the main business account.
	 *
	 * @return void
	 */
	protected function makePayment($receiver, $amount, $cur)
	{
        $receiver      = $receiver;
        $amounttosend  = $amount;
        $currency      = $cur;
        $fee            = 0;
        
        foreach($_POST as $k=>$v) $$k=urldecode($v); 
        $urladdress = "https://solidtrustpay.com/accapi/test.php"; 
       
        $api_pwd = md5(StpayController::$_STP_API_PASSWORD.'s+E_a*'); 
        //change tesmode to 0 to render live transactions
        $data = "user=".$receiver. "&testmode=1&api_id=".StpayController::$_STP_API_NAME. "&api_pwd=".$api_pwd.
         "&amount=".$amount."&paycurrency=".$currency."&comments=transfers&fee=".$fee."&udf1=0&udf2=0";
        // Call STP API
        
        $ch = curl_init(); curl_setopt($ch, CURLOPT_URL,"$urladdress"); 
        curl_setopt($ch, CURLOPT_POST, 1); 
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
        curl_setopt($ch, CURLOPT_HEADER, 0); //use this to suppress output 
        //curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,false);// tell cURL to graciously accept an SSL certificate 
        $result = curl_exec ($ch) or die(curl_error($ch)); 
        echo $result; 
        echo curl_error($ch); 
        curl_close ($ch);
        
	}
    /**
     * handle payment notifications from STP API server
     * 
     */ 
     public function notifPayment(){
        $notification = array('merchantAccount'=>Input::get('merchantAccount'),
                            'item_id'=>Input::get('item_id'),
                            'amount'=>Input::get('amount'), //actual amount transferred to account
                            'notify_url'=>Input::get('notify_url'),
                            'return_url'=>Input::get('return_url'),
                            'cancel_url'=>Input::get('cancel_url'),
                            'testmode'=>Input::get('testmode'),
                            'memo'=>Input::get('memo'),
                            'payerAccount'=>Input::get('payerAccount'),
                            'tr_id'=>Input::get('tr_id'), //transaction id, used for tracking transactions
                            'status'=>Input::get('status'));
                            
        print_r($notification);
        //transaction verification and authentication scheme
        $secondary_password = 'Creationfox7!';
        $secondary_password = md5($secondary_password.'s+E_a*');  //encryption for db
        $hash_received = MD5($_POST['tr_id'].":".MD5($secondary_password).":".$_POST['amount']."
        :".$_POST['merchantAccount'].":".$_POST['payerAccount']);

        if ($hash_received == $_POST['hash']) {
        // valid payment
        }
        else {
            // invalid payment; the payment has been altered
        }    
        
     }
     /**
      * manage confirm requests from STP API server
      */ 
      public function confirmPayment(){
        $payment = array('stp_transact_status'=>Input::get('merchantAccount'),
                            'date'=>Input::get('date'),
                            'amount'=>Input::get('amount'), //actual amount transferred to account
                            'member'=>Input::get('member'),
                            'item_id'=>Input::get('item_id'),
                            'email'=>Input::get('email'),
                            'memo'=>Input::get('memo'),
                            'tr_id'=>Input::get('tr_id'));
                            
        print_r($payment);
         //transaction verification and authentication scheme
        $secondary_password = 'Creationfox7!';
        $secondary_password = md5($secondary_password.'s+E_a*');  //encryption for db
        $hash_received = MD5($_POST['tr_id'].":".MD5($secondary_password).":".$_POST['amount']."
        :".$_POST['merchantAccount'].":".$_POST['payerAccount']);

        if ($hash_received == $_POST['hash']) {
        // valid payment
        }
        else {
            // invalid payment; the payment has been altered
        }   
      }
      /**
       * 
       */
       public function cancelTransaction(){
        
            return Redirect::route('dashboard')
			             	->with('alertError', 'STP Transaction cancelled by user');
       } 

}
