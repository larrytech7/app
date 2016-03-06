<?php
include_once('PaymentUtil.php');

class DashboardController extends BaseController {
	
	public function dashboard(){

			$user = User::find(Auth::user()->id);
			
			return View::make('site.dashboard')
				->with('user', $user)
				->with('title', 'IzePay - User Dashboard');
	}

	public function viewUserProfile(){
		$user = User::find(Auth::user()->id);
			
			return View::make('site.userprofile')
				->with('user', $user)
				->with('title', 'IzePay - User Profile');
	}

    public function uploadPhoto() {

        $userEdit = User::find(Auth::user()->id);

        // delete existing logo if any
        if ($userEdit->photo != null) {
            File::delete('photo/'.$userEdit->photo);
            File::delete('photo/'.$userEdit->photo_thumbnail);
        }

        // uploading and setting of new profile photo
        $photo = bin2hex(openssl_random_pseudo_bytes(20)). '_'. '.'.Input::file('photo')->getClientOriginalExtension();
        $photo_thumbnail = bin2hex(openssl_random_pseudo_bytes(20)). '_'. 'thumbnail'. '.'.Input::file('photo')->getClientOriginalExtension();
        Input::file('photo')->move('photo/', $photo);
        File::copy('photo/'.$photo, 'photo/'.$photo_thumbnail);

        Image::make('photo/'.$photo)->resize(170, 200)->save('photo/'.$photo);
        Image::make('photo/'.$photo_thumbnail)->resize(48, 48)->save('photo/'.$photo_thumbnail);

        $userEdit->photo = $photo;
        $userEdit->photo_thumbnail = $photo_thumbnail;
        $userEdit->save();

        return Redirect::back();
    }
    
    public function about(){
        try{
            $user = User::find(Auth::user()->id);
            return View::make('site.about')
                    ->with('title', 'IzePay - About')
                    ->with('user', $user);
        }catch(Exception  $ex){
            return View::make('site.about')
                ->with('title', 'IzePay - About');
        }
    }
    
    public function privacy(){
        try{
            $user = User::find(Auth::user()->id);
            return View::make('site.privacy')
                    ->with('title', 'IzePay - Privacy')
                    ->with('user', $user);
        }catch(Exception $ex){
            return View::make('site.privacy')
                    ->with('title', 'IzePay - Privacy');            
        }
    }
    
    public function terms(){
        try{
            $user = User::find(Auth::user()->id);
            return View::make('site.terms')
                    ->with('title', 'IzePay - Terms and Conditions')
                    ->with('user', $user);
        }catch(Exception $ex){
            return View::make('site.terms')
                    ->with('title', 'IzePay - Terms and Conditions');            
        }
    }
    
    public function convert(){
        $from = Input::get('from');
        $to = Input::get('to');
        $amount = (double) Input::get('amount');
        
        $converter = new PlatformCharges($amount, $from, $to);
//        echo round($converter->convertCurrency($from, $to, $amount), 2) .' '.$to ;
        echo round($converter->convertCurrency($from, $to, $amount), 3) .' '.$to ;
    }
    //developper/merchant functionality
    public function devzone(){
 			
        $user = User::find(Auth::user()->id);
        $data['developers'] = Developer::where('dev_id', '=', Auth::user()->id)->orderBy('created_at', 'desc')->get();
			
        return View::make('dev.developer')
                    ->with($data)
				    ->with('user', $user)
				    ->with('title', 'HyboPay - Merchant|Developer');
    }

}