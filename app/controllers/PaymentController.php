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

class PaymentController extends BaseController {

    private $_api_context;

    public function __construct() {
        // setup PayPal api context
        $paypal_conf = Config::get('paypal');
        $this->_api_context = new ApiContext(new OAuthTokenCredential($paypal_conf['client_id'], $paypal_conf['secret']));
        $this->_api_context->setConfig($paypal_conf['settings']);
    }
    
    public function postPayment() {

        $name = 'Transaction';

        $mmnumber      = Input::get('number');
        $amounttosend  = Input::get('amount');
        $currency   = Input::get('currency');
        $type       = Input::get('target'); //destination/receipient's payment Provider
        $cno        = Input::get('cardnumber');
        
        $charges = new PlatformCharges($amounttosend, $currency, $type);
        $desc    = $charges->getReceiverType($type);
        
        Session::set('destProvider', $type);
        Session::set('destination', $mmnumber);
        
        if($type == 'pp'){
            return Redirect::route('dashboard')
                    ->with('alertError', 'You need to select different payment system for sender and receiver');
           // exit();
        }
        if(isset($cno) && !empty($cno)){
            //Credit card is being used. Process credit card
            $cc_number  = Input::get('cardnumber');
            $cc_cvv     = Input::get('cvv');
            $cc_exdate  = Input::get('expire');
            $cc_fname   = Input::get('fname');
            $cc_lname   = Input::get('lname');
            $cc_type    = Input::get('cctype');
            
            //set credit card info
            $ccard = new CreditCard();
            $ccard->setType($cc_type);
            $ccard->setNumber($cc_number);
            $ccard->setCvv2($cc_cvv); $date = explode('-', $cc_exdate);
            $ccard->setExpireMonth($date[1]);
            $ccard->setExpireYear($date[0]);
            $ccard->setFirstName($cc_fname);
            $ccard->setLastName($cc_lname);
            //set funding Instrument
            $fundingInstrument = new FundingInstrument();
            $fundingInstrument->setCreditCard($ccard);
            //set funding instrument list
            
            //set payer info
            $payer = new Payer();
            $payer->setFundingInstruments(array($fundingInstrument));
            $payer->setPaymentMethod('credit_card');
            
            //set amount and currency
            $amount = new Amount();
            $amount->setCurrency('USD')
                   ->setTotal($charges->getDueAmount('pp', $type) + 0.5 );
            //set item
            $item_1 = new Item();
            $item_1->setName('Money Transfer') // item name
                ->setDescription("Send money to a $desc User")
    	        ->setCurrency('USD')
    	        ->setQuantity(1)
    	        ->setPrice($charges->getDueAmount('pp', $type) + 0.5 ); // unit price)
    
        	// add item to list
            $item_list = new ItemList();
            $item_list->setItems(array($item_1));
            //set Transaction
            $transaction = new Transaction();
            $transaction->setAmount($amount)
                        ->setItemList($item_list)
                        ->setDescription("Send money To a $desc User");
                    
            //set transacion list
            
            //redirect urls
            $redirect_urls = new RedirectUrls();
            $redirect_urls->setReturnUrl(URL::route('payment-status'))
    		              ->setCancelUrl(URL::route('payment-status'));
                      
            //set payment
            $payment = new Payment();
            $payment->setIntent('sale')
    	        ->setPayer($payer)
    	        ->setRedirectUrls($redirect_urls)
    	        ->setTransactions(array($transaction));
                
            //launch paypal processing request
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
                }else{
                    print_r($payment->getLinks());
//                    return  "Error! No redirect URL!!!";
                }
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
                return Redirect::route('dashboard')
                                ->with('alertError', 'CC Processing Error! '.$ex->getMessage());
            }
    
            return  "Error!!!!";
            
        }
        //end credit card processing

        $payer = new Payer();
        $payer->setPaymentMethod('paypal');// Valid Values: ["credit_card", "bank", "paypal", "pay_upon_invoice", "carrier"]
        
        //TODO:: try to deduce the receiver type (email or number) and set the payerinfo data correctly for consistency
        $payerInfo = new PayerInfo();
        $payerInfo->setFirstName($mmnumber); //used to represent the receiver name/number/email
        $payerInfo->setLastName('Paypal to '.$desc); //used to pass the transaction type in the request
        
        $payer->setPayerInfo($payerInfo);
    
        $item_1 = new Item();
        $item_1->setName('Money Transfer') // item name
                ->setDescription("Send money to a $desc User")
    	        ->setCurrency('USD')
    	        ->setQuantity(1)
    	        ->setPrice($charges->getDueAmount('pp', $type) + 0.5 ); // unit price)
    
    	// add item to list
        $item_list = new ItemList();
        $item_list->setItems(array($item_1));
    
        $amount = new Amount();
        $amount->setCurrency('USD')
               ->setTotal($charges->getDueAmount('pp', $type) + 0.5 );
    
        $transaction = new Transaction();
        $transaction->setAmount($amount)
    		        ->setItemList($item_list)
    		        ->setDescription('Send money To a Mobile Money User');
    
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
            return Redirect::route('dashboard')
                            ->with('alertError', 'Error! '.$ex->getMessage());
        }
    
    }

    //results from the request processed by PayPal
    public function getPaymentStatus() {
    // Get the payment ID before session clear
    $payment_id = Session::get('paypal_payment_id');

    // clear the session payment ID
    Session::forget('paypal_payment_id');

    /*if (empty(Input::get('PayerID')) || empty(Input::get('token'))) {
        return Redirect::route('original.route')
            ->with('error', 'Payment failed');
    }
    */
    // Get the Payer id and token
    $payer_id = Input::get('PayerID');
    $token = Input::get('token');
    // If any of the two is empty, payment was not made
    if (empty($payer_id) || empty($token)) 
    {
        return Redirect::route('dashboard')
                        ->with('alertError', 'Paypal Transaction aborted');
    }

    $payment = Payment::get($payment_id, $this->_api_context);

    // PaymentExecution object includes information necessary 
    // to execute a PayPal account payment. 
    // The payer_id is added to the request query parameters
    // when the user is redirected from paypal back to your site
    $execution = new PaymentExecution();
    $execution->setPayerId(Input::get('PayerID'));

    //Execute the payment
    $result = $payment->execute($execution, $this->_api_context);

    /*return Redirect::route('dashboard')
                        ->with('alertMessage', 'Transaction Successful');
                        */
        $transaction_json  = json_decode($result->getTransactions()[0], TRUE);
        //get Payer details
        $payer['email'] = $result->getPayer()->getPayerInfo()->getEmail();
        $payer['phone'] = $result->getPayer()->getPayerInfo()->getPhone();
        $payer['name'] = $result->getPayer()->getPayerInfo()->getFirstName().$result->getPayer()->getPayerInfo()->getLastName()
        .$result->getPayer()->getPayerInfo()->getMiddleName();
        
        //retrieve transaction destination user NOT our business account, set before transaction request was sent to paypal
        

        $transaction = new IcePayTransaction();
        $transaction->user_id = Auth::user()->id;
        $transaction->tid = $result->getId(); //transaction id or transaction bordereaux
        $transaction->sender_email = Auth::user()->email;//$payer['email']; //sender's email
        $transaction->receiver_email = Session::get('destination'); //receiver's email or number)
        $transaction->type = 'PAYPAL_TO_'.Session::get('destProvider').'_'.$transaction_json['related_resources'][0]['sale']['payment_mode'];
        $transaction->status = 'pending';//$transaction_json['related_resources'][0]['sale']['state'];
        $transaction->amount = $transaction_json['amount']['total']; //total amount deducted and transferred
        $transaction->currency = $transaction_json['amount']['currency'];
        $transaction->save();
        
        $email = Auth::user()->email;//$payer['email'];
        $username = Auth::user()->username;
        
        //send transaction email to sender confirming transactions in a much professional way.
        	Mail::send(['html'=>'emails.auth.transactionemail'], array('tdate' => date('Y-m-d H:i:s'),
                                                            'tid' => $result->getId(),
                                                               'sender_email'=>Auth::user()->email,
                                                               'sender_number'=>Auth::user()->number,
                                                               'receiver_email'=>$result->getPayer()->getPayerInfo()->getFirstName(),
                                                               'receiver_number'=>$result->getPayer()->getPayerInfo()->getFirstName(),
                                                               'status'=>'PENDING',
                                                               'amount'=>($transaction_json['amount']['total'] - 0.5 ).' '.$transaction_json['amount']['currency'],
                                                               'charge'=>'0.5 '.$transaction_json['amount']['currency'],
                                                               'total'=>$transaction_json['amount']['total'].' '.$transaction_json['amount']['currency'],
                                                               'mode'=>$result->getPayer()->getPayerInfo()->getLastName())
                                                               , function($message) use ($email, $username){
		      			$message->to(array($email,'larryakah@gmail.com'), $username)->subject('Transaction Receipt');
			     	});
        
//        return Redirect::route('dashboard')
//                        ->with('alertMessage', 'Transaction Successful');

    if ($result->getState() == 'approved') { // payment made
         return Redirect::route('dashboard')
                        ->with('alertMessage', 'Transaction Successful');
 //       return Redirect::route('original.route')
   //         ->with('success', 'Payment successful');
    }
    return "Error!!!";
    }

    //function to simulate mobile money
    public function postTransfer(){
        $email      = Input::get('number');
        $amounttosend     = Input::get('amount');
        $transaction_id       = str_random(10);

        $transaction = new IcePayTransaction();
        $transaction->user_id = Auth::user()->id;
        $transaction->tid = $transaction_id;
        $transaction->sender_email = Auth::user()->email;
        $transaction->receiver_email = $email;
        $transaction->type = 'MM_TRANSFER';
        $transaction->status = 'pending';
        $transaction->amount = $amounttosend;
        $transaction->currency = 'XAF';
        $transaction->save();

        return Redirect::route('dashboard')
                        ->with('alertMessage', 'Transaction Successful');
    }

    public function viewTransaction(){

       // $user = User::find(Auth::user()->id);
        $user = User::find(Auth::user()->id);
       /* $transactions = IcePayTransaction::find(Auth::user()->id);
        $t = &$transactions;

       // return var_dump($transactions);

        return $transactions != NULL? View::make('site.transaction')
                    ->with('user', $user)
                    ->with('transactions', $transactions->all())
                    ->with('title', 'IcePay - Dashboard')
                    :
                    View::make('site.transaction')
                    ->with('user', $user)
                    ->with('transactions', $t)
                    ->with('title', 'IcePay - Dashboard')
                    ;
                    */
        $data['user'] = User::find(Auth::user()->id);
        $data['transactions'] = IcePayTransaction::where('user_id', '=', Auth::user()->id)->orderBy('created_at', 'desc')->paginate(5);

        return View::make('site.transaction')->with($data)->with('title', 'IzePay - Transactions');
    }
}
