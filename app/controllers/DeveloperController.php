<?php

use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\PayerInfo;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\ExecutePayment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\Transaction;
use PayPal\Api\CreditCard;
use PayPal\Api\FundingInstrument;

require_once('PaymentUtil.php');

class DeveloperController extends BaseController {
	
    public function __construct() {
        // setup PayPal api context
        $paypal_conf = Config::get('paypal');
        $this->_api_context = new ApiContext(new OAuthTokenCredential($paypal_conf['client_id'], $paypal_conf['secret']));
        $this->_api_context->setConfig($paypal_conf['settings']);
    }
    
	public function createDeveloper(){
	   
		$validator = Validator::make(Input::all(),
			array(
				'dev_username'  =>'required|unique:developers|alpha_num|min:4',
				'dev_email'	    =>'required|email',
				'dev_phone'  	=>'required|numeric|min:9'
			)
		);

		if ($validator->fails()) {
//		    print_r($validator->errors());
			return Redirect::route('developer')
					->withErrors($validator)
                    ->with('alertError','Error! Please correct the errors on the form and try again')
					->withInput();
		} else{
		  //create developer account
          $devaccount = new Developer();
          $salt = '**i_hy';
          $devaccount->dev_id = Auth::user()->id;
          $devaccount->dev_key = sha1(base64_encode(Input::get('dev_username')).$salt);
          $devaccount->dev_username = Input::get('dev_username');
          $devaccount->dev_email    = Input::get('dev_email');
          $devaccount->dev_number   = Input::get('dev_phone');
          $devaccount->dev_paymentprovider = Input::get('merhantprovider');
          $devaccount->dev_status   = 0; //sandbox mode
          
			if ($devaccount->save()) {
				// Redirect to the developer page
				return Redirect::route('developer')
						->with('alertMessage', 'New developer account created');
			} else{
				return Redirect::route('developer')
						->with('alertError', 'Unable to add developer account. A similar account already exists.');
			}
		}

		return Redirect::route('developer')
				->with('alertError', 'There was a problem adding your developer account. Please try again');
	}
    
    //switch account to live mode
	public function switchToLive($api_key){

		$user = User::where('code', '=', $api_key)->where('active', '=', 0);

		if ($user->count()) {
			$user = $user->first();

			// Update user to active state
			$user->active = 1;
			$user->$api_key   = '';

			if ($user->save()) {
				return Redirect::route('home')
						->with('alertMessage', 'Account activated! You can now sign in!');
			}
		}

		return Redirect::route('home')
				->with('alertMessage', 'We could not activate your account. Try again later.');
	}
    
    //show various payment methods so as to allow users seelct a payment method
    public function purchase(){
       $data = array(
            Input::get('apikey'),
            Input::get('currency'),
            Input::get('amount'),
            Input::get('return_url'),
            Input::get('payprovider'),
            Input::get('cdata1'),
            Input::get('cdata2')
       );
        return View::make('merchant.purchase')
                    ->with('data', $data)
                    ->with('title', 'HyboPay - Purchase Method');
    }
    
    //handle client login for purchase operation
    public function doPurchase(){
        $validator = Validator::make(Input::all(),
			array(
				'username'	=> 'required|alpha_dash|min:4',
				'password'	=>'required|alpha_num|min:6'
			)
		);

		if ($validator->fails()) {
			return Redirect::route('sandbox/api/merchantapi')
					->withErrors($validator)
					->withInput();
		} else{
			$auth = Auth::attempt(array(
				'username' => Input::get('username'),
				'password' => Input::get('password'),
				'active'   => 1
			));

			if ($auth) {
			     
				// Redirect to the intended page
                $data['data'] = array(
                    Input::get('apikey'),
                    Input::get('currency'),
                    Input::get('amount'),
                    Input::get('return_url'),
                    Input::get('payprovider'),
                    Input::get('cdata1'),
                    Input::get('cdata2')
               );
               $client     = User::find(Auth::user()->id); //the client making the payment
               $merchant = Developer::where('dev_key', '=',$data['data'][0])->get(); //the merchant to whom to make payment to
                
               if($data['data'][4] == 'solidtrustpay'){
                    $url = 'https://solidtrustpay.com/handle_accver.php';
                    $fields = array(
                                            'merchantAccount'   => 'larryakah',
                                            'item_id'           => 'Item Purchase: '.$data['data'][5],
                                            'amount'            => $data['data'][2],
                                            'currency'          => $data['data'][1],
                                            'confirm_url'       => URL::route('dashboard').'/stpconfirm',
                                            'testmode'          => 'on',
                                            'user1'             => 'larryakah@gmail.com',
                                            'user2'             => 'larryakah@gmail.com',
                                            'return_url'        => URL::route('dashboard'),
                                            'notify_url'        => URL::route('dashboard'),
                                            'cancel_url'        => URL::route('dashboard')
                                    );
               
                    $context = stream_context_create(array(
                            'http' => array(
                                'Content-Type'=>'application/x-form-urlencoded',
                                'method'=>'POST',
                                'content'=>http_build_query($fields)
                            )
                    ));
                    echo file_get_contents($url, null, $context);
               /*   
                    //url-ify the data for the POST
                    $fields_string = '';
                    foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
                    rtrim($fields_string, '&');
                    
                    //open connection
                    $ch = curl_init();
                    
                    //set the url, number of POST vars, POST data
                    curl_setopt($ch,CURLOPT_URL, $url);
                    curl_setopt($ch,CURLOPT_POST, count($fields));
                    curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
                   // curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    
                    //execute post
                    $result = curl_exec($ch);
                    var_dump($result);
                    return Redirect::away($url)
                        ->withInput();
               */
                    //close connection
                   // curl_close($ch);
                }//end solid trust pay payment method
                //Session::put('data', $data);
				//return Redirect::action('url')->withInput();
                else
                return Redirect::away('https://solidtrustpay.com/handle.php')
                        ->withInput();
			} else{
				return Redirect::route('sandbox/api/merchantapi')
						->with('alertError', 'Username/Password wrong, or account not activated.');
			}
		}

	//	return Redirect::route('sandbox/api/merchantapi')
		//		->with('alertError', 'There was a problem loging you in.');
    }
    //stp purchase confirmed by user
    public function confirmStpPurchase(){
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
    //stp purchase cancelled by user
    public function cancelStpPurchase(){
        var_dump(Input::get());
        //return Redirect::away(Input::get('user1'))
		//	             	->withInput('alertError', 'STP Transaction cancelled by user');
    }
    //pay with paypal method
        public function payWithPaypal() {
        //purchase parameters
        $mmnumber      = Input::get('number');
        $apikey         = Input::get('apikey');
        $amounttosend  = Input::get('amount');
        $currency      = Input::get('currency');
        $item          = Input::get('item_name');
        $cancel_url    = Input::get('cancel_url');
        $confirm_url   = Input::get('confirm_url');
       // $cno        = Input::get('cardnumber');
        $developers = Developer::where('dev_key', '=',$apikey)
                                ->where('dev_status', '=', 1)
                                ->limit(1)
                                ->get();
        if($developers != null){
            foreach($developers as $developer){
                $mmnumber = $developer->dev_email.' | '.$developer->dev_number.' | '.$developer->dev_username;
                $type   = $developer->dev_paymentprovider;
             //   echo $mmnumber;
              //  echo '<BR/>'.$type;
            }
        }else{
            Redirect::away($cancel_url);
        }
        
        $charges = new PlatformCharges($amounttosend, $currency, $type);
//        $desc    = $charges->getReceiverType($type);
        
        Session::set('destProvider', $type);
        Session::set('destination', $mmnumber);

        $payer = new Payer();
        $payer->setPaymentMethod('paypal');// Valid Values: ["credit_card", "bank", "paypal", "pay_upon_invoice", "carrier"]
        
        //TODO:: try to deduce the receiver type (email or number) and set the payerinfo data correctly for consistency
        $payerInfo = new PayerInfo();
        $payerInfo->setFirstName($mmnumber); //used to represent the receiver name/number/email
        $payerInfo->setLastName('Item: '); //used to pass the transaction type in the request
        
        $payer->setPayerInfo($payerInfo);
    
        $item_1 = new Item();
        $item_1->setName('Item purchase') // item name
                ->setDescription("Purchase made for $item")
    	        ->setCurrency('USD')
    	        ->setQuantity(1)
    	        ->setPrice($charges->getDueAmount('pp', $type) + 0.5 ); // unit price
    
    	// add item to list
        $item_list = new ItemList();
        $item_list->setItems(array($item_1));
    
        $amount = new Amount();
        $amount->setCurrency('USD')
               ->setTotal($charges->getDueAmount('pp', $type) + 0.5 );
    
        $transaction = new Transaction();
        $transaction->setAmount($amount)
    		        ->setItemList($item_list)
    		        ->setDescription('Payment for $item');
    
        $redirect_urls = new RedirectUrls();
        $redirect_urls->setReturnUrl(URL::route('payment-status'))
    		          ->setCancelUrl(URL::route('payment-status'));
    
        $payment = new Payment();
        $payment->setIntent('sale')
    	        ->setPayer($payer)
    	        ->setRedirectUrls($redirect_urls)
    	        ->setTransactions(array($transaction));
    
    	try {
                $payment->create($this->_api_context);
                 foreach($payment->getLinks() as $link) {
                if($link->getRel() == 'approval_url') {
                    $redirect_url = $link->getHref();
                    break;
                }
            }
            // add payment ID to session
            Session::put('paypal_payment_id', $payment->getId());
        
            if(isset($redirect_url)) {
                // redirect to paypal
                return Redirect::away($redirect_url);
            }
    
            return  "Error!!!!";
        } catch (\PayPal\Exception\PPConnectionException $ex) {
            if (\Config::get('app.debug')) {
                echo "Exception: " . $ex->getMessage() . PHP_EOL;
                $err_data = json_decode($ex->getData(), true);
                return Redirect::route('dashboard')
                            ->with('alertError', 'Connection error. $err_data');
                exit;
            } else {
                return Redirect::route('dashboard')
                            ->with('alertError', 'Connection error occured. Please try again later. '.$ex->getMessage());
    //            die('Some error occurred, sorry for the inconvenience. Our team has been notified to correct this error.');
            }
        }catch(Exception $ex){
            return Redirect::away($cancel_url)
                            ->with('alertError', 'Error! '.$ex->getMessage());
        }
    }
    
    //function to process merchant checkout
    public function checkout(){
        try{
            //$data = Session::get('data');
            $chktype = Input::get('method'); //valid expected values are paypal or mobilemoney
            switch($chktype){
                case 'paypal':
                    //call paypal method
                    $this->payWithPaypal();
                    break;
                case 'mobilemoney':
                    //call mobilemoney method
                    
                    break;
            }
            
        }catch(Exception $x){
            return Redirect::route('sandbox/api/merchantapi')
                        ->with('alertError', ''.$x->getMessage());
        }
    }

}
