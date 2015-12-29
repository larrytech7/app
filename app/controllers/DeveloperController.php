<?php

class DeveloperController extends BaseController {
	
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
    
    //function to process merchant checkout
    public function checkoutMerchant(){
        try{
            //$data = Session::get('data');
            echo Input::get('me');
            
            //var_dump(Session::get('data'));
            //Session::forget('data');
            //Session::flush();
        }catch(Exception $x){
            return Redirect::route('sandbox/api/merchantapi')
                        ->with('alertError', 'You must login to proceed');
        }
    }
    
    //show login to authenticate a client during merchant checkout
    public function loginMerchant(){
       $data = array(
            Input::get('apikey'),
            Input::get('currency'),
            Input::get('amount'),
            Input::get('return_url'),
            Input::get('payprovider'),
            Input::get('cdata1'),
            Input::get('cdata2')
       );
        return View::make('merchant.login')
                    ->with('data', $data)
                    ->with('title', 'HyboPay - Authenticate');
    }
    
    //handle client login for purchase operation
    public function doLogin(){
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
    
    public function confirmCheckout(){
        
    }

}
