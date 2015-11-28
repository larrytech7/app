<?php
/**
 * @author Larry Akah
 * @date date("Y-m-d")
 * This is the Eway Controller for handling and controlling eway operations
 */  
 require_once(__DIR__.'/../../vendor/eway/eway-rapid-php/include_eway.php');
 use Eway\Rapid\Client;
  
class EwayController extends BaseController {
    
    public static $_EWAY_API_PASSWORD = 'xhqAQ7kH';
    public static $_EWAY_API_KEY = 'F9802CmaYXtFa1S+wEw/+cOuWQNN+kUDZOdiEp3zFa9PUHyAVl8xTnEygC0iBvNriI4A1F';
    public static $_EWAY_ACCOUNT_PASS = 'Creationfox7!';
    public static $_EWAY_API_URL = 'https://sandbox.myeway.com.au/'; //for sandbox. Make sure to check live settings for live mode
    public static $_EWAY_USERNAME = 'larryakah@gmail.com.sand';
    public static $_EWAY_CUSTOMER_ID = '91778763';
    public static $_EWAY_ACCESS_CODE_URL = 'https://api.sandbox.ewaypayments.com/AccessCodesShared'; //live: https://api.ewaypayments.com/AccessCodesShared
    private $client;
    
    //constructor
    public function __construct(){

        $apiEndpoint = Client::MODE_SANDBOX; // Use \Eway\Rapid\Client::MODE_PRODUCTION when you go live
        $this->client = \Eway\Rapid::createClient(EwayController::$_EWAY_API_KEY, EwayController::$_EWAY_API_PASSWORD, $apiEndpoint);
    }

    private function getReceiverType($v){
        if($v == 'pp')
            return 'PayPal';
        else if($v == 'stp')
            return 'Solitd Trust Pay';
        else if($v == 'sk' )
            return 'Skrill';
        else if($v == 'mm')
            return 'Mobile Money';
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
        $desc       = $this->getReceiverType(Input::get('target'));
        
        $transaction = [
                'Customer' => [
                    'FirstName' => 'John',
                    'Street1' => 'Level 5',
                    'Country' => 'cm',
                    'Mobile' => '09 889 6542',
                    'Email' => 'icep603@gmail.com'
                ],
                'Items' => [
                    [
                        'SKU' => mt_rand(),
                        'Description' => 'Hybrid Transfer',
                        'Quantity' => 1,
                        'UnitCost' => 400,
                        'Tax' => 100,
                        // Total is calculated automatically
                    ]
                ],
                'Options' => [
                    [
                        'ReceipientAccountType' => 'M',//$desc,
                    ]
                ],
                'Payment' => [
                    'TotalAmount' => 1000, //$amounttosend,
                    'CurrencyCode' => 'AUD',//$currency
                ],
                'Method' => 'ProcessPayment',
                'RedirectUrl' => URL::route('dashboard').'/ewayconfirm',
                'CancelUrl' => URL::route('dashboard').'/ewaycancel',
                'PartnerID' => EwayController::$_EWAY_CUSTOMER_ID,
                'TransactionType' => \Eway\Rapid\Enum\TransactionType::MOTO,
                'Capture' => true,
                'LogoUrl' => 'http://devpay.iceteck.com/public/images/logo.png',
                'HeaderText' => 'Izepay Money Transfer',
                'Language' => 'EN',
                'CustomView' => 'BootstrapCyborg',
                'VerifyCustomerEmail' => true,
                'CustomerReadOnly' => false
            ];
            try{
                $response = $this->client->createTransaction(\Eway\Rapid\Enum\ApiMethod::RESPONSIVE_SHARED, $transaction);
                var_dump($response);
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
                die();
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
        $response = $this->client->queryTransaction('44DD7aVwPYUPemGRf7pcWxyX2FJS-0Wk7xr9iE7Vatk_5vJimEbHveGSqX52B00QsBXqbLh9mGZxMHcjThQ_ITsCZ3JxKOY88WOVsFTLPrGtHRkK0E9ZDVh_Wz326QZlNlwx2');
        $transactionResponse = $response->Transactions[0];

        if ($transactionResponse->TransactionStatus) {
            echo 'Payment successful! ID: '.$transactionResponse->TransactionID;
        } else {
            $errors = split(', ', $transactionResponse->ResponseMessage);
            foreach ($errors as $error) {
                echo "Payment failed: ".\Eway\Rapid::getMessage($error)."<br>";
            }
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
