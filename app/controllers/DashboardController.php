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
			
			return View::make('dev.developer')
				->with('user', $user)
				->with('title', 'IzePay - Merchant|Developer');
    }

}