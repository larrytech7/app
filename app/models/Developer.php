<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class Developer extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;

	//protected $fillable = array('dev_id', 'dev_key', 'dev_number', 'dev_email', 'dev_username', 'dev_status', 'dev_createddate', 'dev_paymentprovider');

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'developers';

}
