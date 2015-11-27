<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', array(
	'as' => 'home',
	'uses' => 'HomeController@home'

));
/*
| Route to static pages
*/
/* ----------------------------------------------------------------------- */
Route::get('about', array(
	'as' => 'about',
	'uses' => 'DashboardController@about'

	));

Route::get('terms', array(
	'as' => 'terms',
	'uses' => 'DashboardController@terms'

	));

Route::get('privacy', array(
	'as' => 'privacy',
	'uses' => 'DashboardController@privacy'

	));
/* ------------------------------------------------------------------------ */


/* 
| Authentication group
*/
Route::group(array('before' => 'auth'), function(){

	Route::get('dashboard', array(
	'as' => 'dashboard',
	'uses' => 'DashboardController@dashboard'

	));

	Route::get('dashboard/me', array(
	'as' => 'viewprofile',
	'uses' => 'DashboardController@viewUserProfile'

	));

	/*
	| CSRF protection group
	*/
	Route::group(array('before' => 'csrf'), function(){

		/*
		| Change password (POST)
		*/
		Route::post('change-password-post', array(
		'as' => 'change-password-post',
		'uses' => 'AccountController@handleChangePassword'
		));

	});



	/*
	| Change password (GET)
	*/
	Route::get('dashboard/passwordconfig', array(
		'as' => 'dashboard.change-password',
		'uses' => 'AccountController@getChangePassword'
	));


	/*
	| Edit User (GET)
	*/
	Route::controller('dashboard/account', 'AccountController');


	/*
	| Logout
	*/
	Route::get('logout', array(
		'as' => 'logout',
		'uses' => 'AccountController@handleLogout'
	));

});

/* 
| Unauthentication group
*/
Route::group(array('before' => 'guest'), function(){

	/*
	| CSRF protection group
	*/
	Route::group(array('before' => 'csrf'), function(){

		/*
		| Create account (POST)
		*/
		Route::post('register', array(
			'as'=>'register', 
			'uses'=>'AccountController@handleRegister'
		));

		/*
		| Login account (POST)
		*/
		Route::post('login', array(
			'as'=>'login', 
			'uses'=>'AccountController@handleLogin'
		));

	});

	/*
	| Login account (GET)
	*/
	Route::get('login', array(
		'as' => 'get-login',
		'uses' => 'AccountController@getLogin'
	));

	/*
	| Create account (GET)
	*/
	Route::get('create', array(
		'as' => 'account-create',
		'uses' => 'AccountController@getCreate'
	));

	Route::get('activate/{code}', array(
		'as' => 'account-activate',
		'uses' => 'AccountController@handleActivate' 
	));

});


Route::group(array('before' => 'auth'), function(){
	/*
	| PayPay Routes
	*/
	Route::any('payment', array(
	    'as' => 'payment',
	    'uses' => 'PaymentController@postPayment',
	));

	// this is after make the payment, PayPal redirect back to your site
	Route::get('payment/status', array(
		'as' => 'payment-status',
		'uses' => 'PaymentController@getPaymentStatus'
	));

	/*
	| Mobile Money Routes
	*/
	Route::post('transfer', array(
	    'as' => 'transfer',
	    'uses' => 'PaymentController@postTransfer',
	));


	Route::get('dashboard/transaction', array(
		'as' => 'dashboard.transaction',
		'uses' => 'PaymentController@viewTransaction'
	));

});


Route::group(array('before' => 'auth'), function(){
	/*
	| STP Routes
	*/
	Route::any('dashboard/stpnotif', array(
	    'as' => 'stpnotif',
	    'uses' => 'StpayController@notifPayment',
	));

	// handles confirm requests fro STP transactions
	Route::get('dashboard/stpconfirm', array(
		'as' => 'stpconfirm',
		'uses' => 'StpayController@confirmPayment'
	));
    //cancel url
    Route::get('dashboard/cancel', array(
		'as' => 'stpcancel',
		'uses' => 'StpayController@cancelTransaction'
	));

});