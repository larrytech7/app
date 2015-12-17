<?php
/**
 * @author Larry Akah
 * @date date("Y-m-d")
 * This is the Eway Controller for handling and controlling eway operations.
 * This controller is used to process credit cards, visa and mastercards
 */  
 require_once(__DIR__.'/../../vendor/eway/eway-rapid-php/include_eway.php');
 use Eway\Rapid\Client;
 require_once('PaymentUtil.php');
  
class EwayController extends BaseController {
    
    public static $_EWAY_API_PASSWORD = 'xhqAQ7kH';
    public static $_EWAY_API_KEY = 'F9802CmaYXtFa1S+wEw/+cOuWQNN+kUDZOdiEp3zFa9PUHyAVl8xTnEygC0iBvNriI4A1F';
    public static $_EWAY_ACCOUNT_PASS = 'Creationfox7!';
    public static $_EWAY_API_URL = 'https://sandbox.myeway.com.au/'; //for sandbox. Make sure to check live settings for live mode
    public static $_EWAY_API_URL_LIVE = 'https://sandbox.myeway.com.au/';
    public static $_EWAY_USERNAME = 'larryakah@gmail.com.sand';
    public static $_EWAY_CUSTOMER_ID = '91778763';
    public static $_EWAY_ACCESS_CODE_URL = 'https://api.sandbox.ewaypayments.com/AccessCodesShared'; //live: https://api.ewaypayments.com/AccessCodesShared
    public static $_EWAY_ACCESS_CODE_URL_LIVE = 'https://api.ewaypayments.com/AccessCodesShared';
    private $client;
    
    //constructor
    public function __construct(){

        $apiEndpoint = Client::MODE_SANDBOX; // Use \Eway\Rapid\Client::MODE_PRODUCTION when you go live
        $this->client = \Eway\Rapid::createClient(EwayController::$_EWAY_API_KEY, EwayController::$_EWAY_API_PASSWORD, $apiEndpoint);
    }
    
	/**
	 * Make a EWAY payment to the destined user from the main business account.
	 *
	 * @return void
	 */
	protected function makePayment(){
	   
        $receiver      = Input::get('number');
        $amounttosend  = Input::get('amount');
        $currency   = Input::get('currency');
        $destinationProvider = Input::get('target');
        $charges    = new PlatformCharges($amounttosend, $currency, $destinationProvider);
        $desc       = $charges->getReceiverType($destinationProvider);
        $user = User::find(Auth::user()->id);
        
        $transaction = [
                'Customer' => [
                    'FirstName' => Auth::user()->name,
                    'Street1' => 'Level 5',
                    'Country' => 'US',
                    'Mobile' => Auth::user()->number,
                    'Email' => Auth::user()->email
                ],
                'Items' => [
                    [
                        'SKU' => mt_rand(),
                        'Description' => 'Hybrid Transfer to '.$desc.' user',
                        'Quantity' => 1,
                        'UnitCost' => $charges->getDueAmount('ew', $destinationProvider),
                        'Tax' => 100, //$1 applied as charge to every transaction irrespective of the amount transfered
                        // Total is calculated automatically
                    ]
                ],
                'Options' => [
                    [
                        'ReceipientAccountType' => $desc,//Receipient's payement system
                    ],
                    [
                        'Receiver'  =>  $receiver, //receiver's details to which to make the due transfer
                    ],
                    [
                        'currency'  => $currency, // currency used to make the transfer when sending to the receipient
                    ],
                ],
                'Payment' => [
                    'TotalAmount' => $charges->getDueAmount('ew', $destinationProvider) * 100, //$amounttosend,
                    'CurrencyCode' => $currency
                ],
                'Method' => 'ProcessPayment',
                'RedirectUrl' => URL::route('dashboard').'/ewayconfirm',
                'CancelUrl' => URL::route('dashboard').'/ewaycancel',
                'PartnerID' => EwayController::$_EWAY_CUSTOMER_ID,
                'TransactionType' => \Eway\Rapid\Enum\TransactionType::PURCHASE, //normally would be PURCHASE. Modes are MOTO, Recurring
                'Capture' => true,
                'LogoUrl' => 'https://izepay.iceteck.com/public/images/logo.png',
                'HeaderText' => 'Izepay Money Transfer',
                'Language' => 'EN',
                'CustomView' => 'BootstrapCyborg', //Bootstrap, BootstrapAmelia, BootstrapCerulean, BootstrapCosmo, BootstrapCyborg, BootstrapFlatly, BootstrapJournal, BootstrapReadable, BootstrapSimplex, BootstrapSlate, BootstrapSpacelab, BootstrapUnited
                'VerifyCustomerEmail' => true,
                'Capture'       => true,
                'CustomerReadOnly' => false
            ];
            try{
                $response = $this->client->createTransaction(\Eway\Rapid\Enum\ApiMethod::RESPONSIVE_SHARED, $transaction);
                //var_dump($response);
//                echo $response->SharedPaymentUrl;
                //sleep(20);
            }catch(Exception $ex){
                return Redirect::route('dashboard')
			             	->with('alertError', 'Debug Error: '.$ex->getMessage());
            }
            //manage response
            
            if (!$response->getErrors()) {
                // Redirect to the Responsive Shared Page
                header('Location: '.$response->SharedPaymentUrl);
                //die();
            } else {
                foreach ($response->getErrors() as $error) {
                    echo "Response Error: ".\Eway\Rapid::getMessage($error)."<br>";
                }
            }
	}
    
     /**
      * manage confirm requests from EWAY API server
      */ 
      public function confirmPayment(){
        $response = $this->client->queryTransaction(Input::get('AccessCode'));
        $transactionResponse = $response->Transactions[0];

        if ($transactionResponse->TransactionStatus) {
            //echo 'Payment successful! ID: '.$transactionResponse->TransactionID;
            var_dump($transactionResponse->Options
            );
            /*
                $transaction = new IcePayTransaction();
                $transaction->user_id = Auth::user()->id;
                $transaction->tid = $transactionResponse->TransactionID; //transaction id or transaction bordereaux
                $transaction->sender_email = Auth::user()->email;//$payer['email']; //sender's email
                $transaction->receiver_email = $transactionResponse->Options[0]->Receiver; //receiver's email or number
                $transaction->type = 'EWAY_'.$transactionResponse->Options[1]->ReceipientAccountType;
                $transaction->status = 'pending';//$transaction_json['related_resources'][0]['sale']['state'];
                $transaction->amount = $transactionResponse->TotalAmount; //total amount deducted and transferred
                $transaction->currency = $transactionResponse->Options[2]->currency;
                $transaction->save();
                
                $email = Auth::user()->email;//$payer['email'];
                $username = Auth::user()->username;
            
            Mail::send(['html'=>'emails.auth.transactionemail'], array('tdate' => date('Y-m-d H:i:s'),
                                                            'tid' => $transactionResponse->TransactionID,
                                                               'sender_email'=>Auth::user()->email,
                                                               'sender_number'=>Auth::user()->number,
                                                               'receiver_email'=>$transactionResponse->Options[0]->Receiver,
                                                               'receiver_number'=>$transactionResponse->Options[0]->Receiver,
                                                               'status'=>'PENDING',
                                                               'amount'=>$transactionResponse->TotalAmount. ' '.$transactionResponse->Options[2]->currency,
                                                               'charge'=>'0.0 '.$transactionResponse->Options[2]->currency,
                                                               'total'=>$transactionResponse->TotalAmount. ' '.$transactionResponse->Options[2]->currency,
                                                               'mode'=>$result->getPayer()->getPayerInfo()->getLastName())
                                                               , function($message) use ($email, $username){
		      			$message->to($email, $username)->subject('Transaction Receipt');
			     	});
         return Redirect::route('dashboard')
			             	->with('alertMessage', 'EWAY Transaction Successful');
                            */
        } else {
            $errors = str_split($transactionResponse->ResponseMessage); //previously splitte the string at the ', ' points
            foreach ($errors as $error) {
                $errmsg .= "Payment failed: ".\Eway\Rapid::getMessage($error)."<br>";
            }
             return Redirect::route('dashboard')
			             	->with('alertError', $errmsg);
        }
      }
      /**
       * Handles user cancelling the Eway Transaction
       */
       public function cancelTransaction(){
        
            return Redirect::route('dashboard')
			             	->with('alertError', 'EWAY Transaction cancelled by user');
       } 

}
