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
                            'status'=>Input::get('status'),
                            'paymentReceiver'=>Input::get('user1'),
                            'paymentProvider'=>Input::get('user2'));
                            
        //print_r($notification);
        //transaction verification and authentication scheme
        $secondary_password = 'Creationfox7!';
        $secondary_password = md5($secondary_password.'s+E_a*');  //encryption for db
        $hash_received = MD5($_POST['tr_id'].":".MD5($secondary_password).":".$_POST['amount']."
        :".$_POST['merchantAccount'].":".$_POST['payerAccount']);

        if ($hash_received == $_POST['hash']) {
        // valid payment
                
             Mail::send(['html'=>'emails.auth.transactionemail'], array('tdate' => date("Y-m-d H:i:s"),
                                                            'tid' => $notification['tr_id'],
                                                               'sender_email'=>Auth::user()->email,
                                                               'sender_number'=>Auth::user()->number,
                                                               'receiver_email'=>$notification['paymentReceiver'],
                                                               'receiver_number'=>$notification['paymentReceiver'],
                                                               'status'=>'PENDING',
                                                               'amount'=>$notification['amount'],
                                                               'charge'=>'0.0 USD',
                                                               'total'=>$notification['amount'].' ',
                                                               'mode'=>'STP to '.$notification['paymentProvider'])
                                                               , function($message) use ($email, $username){
		      			$message->to(array($email,'larryakah@gmail.com'), $username)->subject('Transaction Receipt');
			     	});
         return Redirect::route('dashboard')
        	               ->with('alertMessage', 'STP Notification. Transaction successful');
        }
        else {
            // invalid payment; the payment has been altered
            return Redirect::route('dashboard')
           	                ->with('alertError', 'Notification. Invalid Payment. The payment may have been altered. Please try again');
        }    
        
     }
     /**
      * Manage confirm requests from STP API server
      * Confirm payment was actually made and effective.
      * Notify platform admin to proceed with payment to the receiver from the appropriate platform
      */ 
      public function confirmPayment(){
        $payment = array('stp_transact_status'=>Input::get('merchantAccount'),
                            'date'=>Input::get('date'),
                            'amount'=>Input::get('amount'), //actual amount transferred to account
                            'member'=>Input::get('member'),
                            'item_id'=>Input::get('item_id'),
                            'email'=>Input::get('email'),
                            'memo'=>Input::get('memo'),
                            'tr_id'=>Input::get('tr_id'),
                            'receiver'=>Input::get('user1'),
                            'provider'=>Input::get('user2'));
                            
        print_r($payment);
         //transaction verification and authentication scheme
        $secondary_password = 'Creationfox7!';
        $secondary_password = md5($secondary_password.'s+E_a*');  //encryption for db
        $hash_received = MD5($_POST['tr_id'].":".MD5($secondary_password).":".$_POST['amount']."
        :".$_POST['merchantAccount'].":".$_POST['payerAccount']);

        if ($hash_received == $_POST['hash']) {
        // valid payment
        
                $transaction = new IcePayTransaction();
                $transaction->user_id = Auth::user()->id;
                $transaction->tid = $payment['tr_id']; //transaction id or transaction bordereaux
                $transaction->sender_email = Auth::user()->email;//$payer['email']; //sender's email
                $transaction->receiver_email = $payment['receiver']; //receiver's email or number
                $transaction->type = 'STP to '.$payment['provider'];
                $transaction->status = 'pending';//$transaction_json['related_resources'][0]['sale']['state'];
                $transaction->amount = $payment['amount']; //total amount deducted and transferred
                $transaction->currency = '';
                $transaction->save();
            Mail::send(['html'=>'emails.auth.transactionemail'], array('tdate' => $payment['date'],
                                                            'tid' => $payment['tr_id'],
                                                               'sender_email'=>Auth::user()->email,
                                                               'sender_number'=>Auth::user()->number,
                                                               'receiver_email'=>'TEST',
                                                               'receiver_number'=>$payment['receiver'],
                                                               'status'=>'PENDING',
                                                               'amount'=>$payment['amount'],
                                                               'charge'=>'0.0 USD',
                                                               'total'=>$payment['amount'].' ',
                                                               'mode'=>'STP to '.$payment['provider'])
                                                               , function($message) use ($email, $username){
		      			$message->to($email, $username)->subject('Transaction Receipt');
			     	});
         return Redirect::route('dashboard')
        	               ->with('alertMessage', 'STP Transaction successful');
        }
        else {
            // invalid payment; the payment has been altered
            return Redirect::route('dashboard')
           	                ->with('alertError', 'Invalid Payment. The payment may have been altered. Please try again');
        }   
      }
      /**
       * Called when user cancels the transcaction from the STP transactions page.
       */
       public function cancelTransaction(){
       
            return Redirect::route('dashboard')
			             	->with('alertError', 'STP Transaction cancelled by user');
       } 

}
