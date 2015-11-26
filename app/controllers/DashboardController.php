<?php

class DashboardController extends BaseController {
	
	public function dashboard(){

		//if (Auth::check()) {

			$user = User::find(Auth::user()->id);
			
			return View::make('site.dashboard')
				->with('user', $user)
				->with('title', 'IcePay - User Dashboard');
		//} else {
			//return Redirect::route('home');
		//}
		
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

}