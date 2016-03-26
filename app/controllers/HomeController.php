<?php

class HomeController extends BaseController {
	public function home(){

		/*Mail::send('emails.auth.test', array('name' => 'IcePay'), function($message){
			$message->to('rocardpp@gmail.com', 'IceTeck Developer test mail')->subject('Test email');
		});*/

		if (Auth::check()) {
			$user = User::find(Auth::user()->id);
			
			return View::make('site.dashboard')
				->with('user', $user)
				->with('title', 'IzePay - User Dashboard');
		}
        $videos = array('m2.mp4','m4.mp4','m5.mp4','mouse2.mp4');
        $position = rand(0,3);
        $video_url = URL::to('public/video').'/'.$videos[$position];

		return View::make('site.home')
				->with('title', 'Izepay - Simplifying cross wallet money transfer and payments')
                ->with('video_url', $video_url);
	}

}
