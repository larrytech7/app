<?php
/**
 * @author Larry Akah
 * @date date("Y-m-d")
 * This is the MOBILE MONEY Controller for handling and controlling MM operations
 */
 require_once('PaymentUtil.php');
   
class MobilemoneyController extends BaseController {

	/**
	 * Make a MM payment to the destined user from the main business account.
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
        
        $initAmount = $Amount;
        $Amount = (int) $Amount + ((2/100) * $Amount);
        
        $mes_donnees = array('MyAccountID'=> $AccountID, 'CustomerPhonenumber' => $Phonenumber, 'Amount' => $Amount);
        
        $postdata = http_build_query($mes_donnees);
        
        $url = 'http://api.furthermarket.com/FM/MTN/MoMo/requestpayment?';
        //make request and fetch result
        $ch = curl_init();	//  Initiate curl
		curl_setopt($ch, CURLOPT_TIMEOUT, 300); //timeout in seconds (300)
	//	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
	//	curl_setopt($ch, CURLOPT_POST, 1);                                                                     
	//	curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);                                                              
	//	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/xml','Content-Length:'.strlen($url.$postdata)));
		curl_setopt($ch, CURLOPT_HEADER, 0);  //TRUE to include the header in the output.
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0); //0 = wait indefinitely while trying to connect 
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);	// Will return the response, if false it print the response
		curl_setopt($ch, CURLOPT_URL,$url.$postdata);	// Set the url
	
		$result = curl_exec($ch);	// Execute
		$httpstatus = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		$curl_errno = curl_errno($ch);
        
        /*
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
        */
        //process the result here
        $params = explode(',', $result, 3); //[0] = 1 or 0, [1] = payment id, [2] = message for success
        //create amount to send to user provider in USD
        $montant = new PlatformCharges($initAmount, 'XAF', $dest_provider);
        
        if($params[0] == 1 && isset($params[2])){ //verify for successful transaction and save to dba nd email receipt
            
        $transaction = new IcePayTransaction();
        $transaction->user_id = Auth::user()->id;
        $transaction->tid = $params[1]; //transaction id or transaction bordereaux
        $transaction->sender_email = Auth::user()->email;//$payer['email']; //sender's email
        $transaction->receiver_email = $sendto; //receiver's email or number)
        $transaction->type = 'MOMO_TO_'.$dest_provider;
        $transaction->status = 'pending';//$transaction_json['related_resources'][0]['sale']['state'];
        $transaction->amount = $Amount; //total amount deducted and transferred
        $transaction->currency = $currency;
        $transaction->save();
        
        $email = Auth::user()->email;//$payer['email'];
        $username = Auth::user()->username;
        
        //send transaction email to sender confirming transactions in a professional way. send copy to company
        	Mail::send(['html'=>'emails.auth.transactions'], array('tdate' => date('Y-m-d H:i:s'),
                                                            'tid' => $result->getId(),
                                                               'sender_email'=>Auth::user()->email,
                                                               'sender_number'=>Auth::user()->number,
                                                               'receiver_email'=>$sendto,
                                                               'receiver_number'=>$destination,
                                                               'status'=>'PENDING',
                                                               'amount'=>$Amount,
                                                               'charge'=>'2% of '.$Amount.' in '.$currency,
                                                               'total'=> $montant->getDueAmount('mm', $dest_provider),
                                                               'mode'=>$result->getPayer()->getPayerInfo()->getLastName())
                                                               , function($message) use ($email, $username){
		      			$message->to(array($email,'larryakah@gmail.com'), $username)->subject('Transaction Receipt');
			     	});
         
        echo json_encode(
                    array('paymentresult' => $result,//nl2br($UssdResult),
                    'error_no'=>$curl_errno)
            );
        }else{
            echo json_encode(
                    array('paymentresult' => $result,//nl2br($UssdResult),
                    'error'=> 'Transaction failed',
                    'error_no'=>$curl_errno)
            );
        }
        
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
      
      //confirm the transaction and save the result
      public function confirmmomotransaction(){
            $to = Input::get('receiver');
            $from = Input::get('sender');
            $amount = Input::get('amount');
            $provider = Input::get('provider');
            
      }
        /**
       * 
       */
       public function cancelTransaction(){
            return Redirect::route('dashboard')
			             	->with('alertError', 'Mobile Money Transaction cancelled by user');
       } 

}
