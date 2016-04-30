<?php

class AccountController extends BaseController {
	
	public function getLogin(){ 
		return View::make('site.login')
				->with('title', 'HyboPay - LogIn');
	}

	public function handleLogin(){ 
		$validator = Validator::make(Input::all(),
			array(
				'username'	=> 'required|alpha_dash|min:4',
				'password'	=>'required|alpha_num|min:6'
			)
		);

		if ($validator->fails()) {
			return Redirect::route('get-login')
					->withErrors($validator)
					->withInput();
		} else{
			$auth = Auth::attempt(array(
				'username' => Input::get('username'),
				'password' => Input::get('password'),
				'active'   => 1
			));

			if ($auth) {
				// Redirect to the intender page
				return Redirect::route('dashboard')
						->with('alertMessage', 'Your have successfully login to your account');
			} else{
				return Redirect::route('login')
						->with('alertError', 'Username/Password wrong, or account not activated.');
			}
		}

		return Redirect::route('login')
				->with('alertError', 'There was a problem loging you in.');
	}

	public function handleLogout(){
		Auth::logout();
		Session::flush();
		return Redirect::route('home')
				->with('alertMessage', 'Your have logged out of your account.');
	}

	public function getCreate(){
		return View::make('site.register')
				->with('title', 'HyboPay - Registration');
	}

	public function handleRegister(){
		$validator = Validator::make(Input::all(),
			array(
				'username'			=>'required|unique:users|alpha_dash|min:4',
				'email'	  			=>'required|email|unique:users',
				'country' 			=>'required',
				'number'  			=>'required|numeric|min:9',
				'password'			=>'required|alpha_num|min:6',
				'confirm_password'	=>'required|alpha_num|same:password',
				'terms'	   			=>'required'
			)
		);

		if ($validator->fails()) {

			return Redirect::route('home')
					->withErrors($validator)
					->withInput();

		} else{

			$username	= Input::get('username');
			$email		= Input::get('email');
			$number		= Input::get('number');
			$password   = Input::get('password');
			$country	= Input::get('country');
			$newsletter	= (Input::has('newsletter')) ? 1 : 0;

			//Activation code
			$code = str_random(60);

				//Account email
                try{
    				Mail::send('emails.auth.registration', array('link' => URL::route('account-activate', $code),
	       				'username' => $username), function($message) use ($email, $username){
		      			$message->to($email, $username)->subject('Account activation');
			     	});
      			$user = User::create(array(
        				'username' => $username,
        				'email' => $email,
        				'number' => $number,
        				'password' => Hash::make($password),
        				'country' => $country,
        				'newsletter' => $newsletter,
        				'code' => $code,
        				'active' => 0
        			));
                    
     				return Redirect::route('home')
						->with('alertMessage', 'Your account has been created! We have sent you an email to verify and activate your account.');
                }catch(Exception $ex){
                    return Redirect::route('home')
						->with('alertError', 'Error! '.$ex->getMessage().'. Please try again later');
                }
		}
	}

	public function handleActivate($code){

		$user = User::where('code', '=', $code)->where('active', '=', 0);

		if ($user->count()) {
			$user = $user->first();

			// Update user to active state
			$user->active = 1;
			$user->code   = '';

			if ($user->save()) {
				return Redirect::route('home')
						->with('alertMessage', 'Account activated! You can now sign in!');
			}
		}

		return Redirect::route('home')
				->with('alertMessage', 'We could not activate your account. Try again later.');
	}

	public function getChangePassword(){
		return View::make('site.password')
					->with('title', 'HyboPay - Change Password');
	}

	public function handleChangePassword(){
		$validator = Validator::make(Input::all(),
			array(
				'old_password' 		=> 'required',
				'password' 			=> 'required|min:6',
				'confirm_password' 	=> 'required|same:password'

			)
		);

		if ($validator->fails()) {
			return Redirect::route('change-password')
					->withErrors($validator);
		} else {

			$user 			= User::find(Auth::user()->id);
			$old_password 	= Input::get('old_password');
			$password 		= Input::get('password');

			if (Hash::check($old_password, $user->getAuthPassword())) {
				$user->password = Hash::make($password);

				if ($user->save()) {
					return Redirect::route('dashboard')
							->with('alertMessage', 'Your password has been changed.');
				}

			} else {
				return Redirect::route('change-password')
					->with('alertError', 'Oops! Your old password is not correct.');
			}

		}

		return Redirect::route('change-password')
				->with('alertError', 'Your password could not be changed.');
	}

	public function getManage($id, $edit){

		$data['user'] = User::find($id);
		return View::make('site.edituser')->with($data)
						->with('title', 'HyboPay - Edit user account');;
	}

	public function postManage(){
        $rules = array(
                'username'			=>'required|alpha_dash',
				'email'	  			=>'required|email',
				'country' 			=>'required',
				'number'  			=>'required',
             );

        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator);
        }

        $userToUpdate = User::find(Input::get('special'));
        $userToUpdate->username = Input::get('username');
        $userToUpdate->email = Input::get('email');
        $userToUpdate->number = Input::get('number');
        $userToUpdate->country = Input::get('country');
        $userToUpdate->newsletter = (Input::has('newsletter')) ? 1 : 0;

        $$userToUpdate->save();

        return Redirect::back()->with('alertMessage', 'Account updated successfully.');
    }

    public function getForgotpasswd() {
    	return View::make('site.forgotpasswd')
				->with('title', 'HyboPay - Forgot Password');
    }

    public function handleForgotpasswd() {
    	
    	$validator = Validator::make(
            Input::all(),
            array('email' => 'required|email')
        );

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator);
        } else {

            $user = User::where('email', '=', Input::get('email'));

            if ($user->count()) {
                $user = $user->first();

                $code = str_random(120);

                $user->remind = $code;
                $user->save();

                $mailData = array(
                'email' => Input::get('email'),
                'link' => $code,
                );
	            
	            //return $mailData['email'] . $training->title;

	            Mail::send('emails.auth.remind',$mailData,
	            	function($message) {
	                     $message->subject("izepay password reset");
	                     $message->to(Input::get('email'));
	                 }
	             );

                return Redirect::back()->with('alertMessage', 'a link has been send to your email to reset your password.');

            } else {
                return Redirect::back()->with('alertError', 'we can not find a user with that email address.');

            }

        }
    }

    public function recovery($link){

		$user = User::where('remind', '=', $link)->first();

		//return var_dump($user->id);

		if ($user->count()) {
			return View::make('password.reset')
				->with('user', $user)
				->with('title', 'IzePay - Recover Password');
		} else {
			return Redirect::back()->with('alertError', 'invalid reset code');

		}

	}

	public function handleRecovery(){

		$messages = array(
            'same'    => 'The :attribute and :other must match.',
            'required' => 'The :attribute field is required.',
            'min'       =>'The :attribute must be atleast :min characters'
        );
        $editData = Input::all();
        $editRules = array(
            'new_password' =>'required|min:6',
            'confirm_new_password' => 'required|same:new_password'
        );

        $editValidator = Validator::make($editData,$editRules);
        if($editValidator->fails()) {   
            return Redirect::back()->withInput()->withErrors($editValidator);
        } 

        if ($editValidator->passes()) {
        	$userToUpdate = User::find(Input::get('special'));
        	$userToUpdate->password = Hash::make(Input::get('new_password'));
        	$userToUpdate->save();

        	return Redirect::to('login')->with('alertMessage',"password reseted successfully. Login now!!!");
        }
	}


}
