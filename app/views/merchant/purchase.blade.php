@extends('layouts.default')

@section('content')
<!-- Heading Row -->
        <div class="row center-align" > <!-- CLIENT LOGO HERE --><img src="" alt="" class="responsive-img"/></div>
        <div class="row">
            <div class="col m4 well">
            </div>
            
            <div class="col s12 m4">    
                    <div class="card blue-grey darken-1 center-align">
                        <span class="card-title">Pay with your preferred method</span>
                        <div class="card-content white-text">
                          
                          <div>
                            {{Form::open(array('url'=>URL::to('sandbox/api/merchantapi/paypal'), 'class'=>'paypal', 'role'=>'form'))}}
                                <input type="hidden" name="extra_data" value="data1" />
                                <input type="hidden" name="apikey" value="{{Input::get('apikey')}}"/>
                                <input type="hidden" name="amount" value="{{Input::get('amount')}}"/>
                                <input type="hidden" name="currency" value="{{Input::get('currency')}}"/>
                                <input type="hidden" name="cancel_url" value="{{Input::get('cancel_url')}}" />
                                <input type="hidden" name="confirm_url" value="{{Input::get('confirm_url')}}" />
                                <input type="hidden" name="item_name" value="{{Input::get('item_name')}}" />
                                <input type="hidden" name="method" value="paypal"/>
                            
                            <a href="#!" class="secondary-content paypal"  title="PayPal">
                                <img src="{{URL::to('public/images')}}/paypa_icon.png" alt="Purchase item with your paypal Account." class="circle responsive" height="50" width="50"/>
                            </a>
                            {{Form::token()}}
                            {{Form::close()}}
                        </div>
                        
                        <div>
                            {{Form::open(array('url'=>'https://solidtrustpay.com/handle_accver.php', 'class'=>'dostpay', 'role'=>'form'))}}
                                <input type="hidden" name="merchantAccount" value="larryakah" />
                                <input type="hidden" name="apikey" value="{{Input::get('apikey')}}"/>
                                <input type="hidden" name="amount" value="{{Input::get('amount')}}"/>
                                <input type="hidden" name="currency" value="{{Input::get('currency')}}"/>
                                <input type="hidden" name="item_id" value="HyboPay purchase with Solid Trust Pay" />
                                <input type="hidden" name="confirm_url" value="{{URL::route('dashboard')}}/stpconfirm" />
                                <input type="hidden" name="testmode" value="on" />
                                <input type="hidden" name="notify_url" value="{{URL::route('sandbox/api/merchantapi/confirmstppurchase')}}" />
                                <input type="hidden" name="return_url" value="{{URL::route('sandbox/api/merchantapi/confirmstppurchase')}}" />
                                <input type="hidden" name="cancel_url" value="{{URL::route('sandbox/api/merchantapi/cancelstppurchase')}}" />
                                <input type="hidden" name="user1" value="{{Input::get('return_url')}}"/> <!-- receiver email, number etc set by js -->
                                <input type="hidden" name="user2" value="xx"/><!-- receiver's payment provider -->
                            
                          <a href="#!" class="secondary-content stpay"  title="Solid Trust Pay">
                            <img src="{{URL::to('public/images')}}/stp_icon.png" alt="Purchase item with your Solid Trust Pay Account." class="circle responsive" height="50" width="50"/>
                          </a>
                          {{Form::token()}}
                        {{Form::close()}}
                        </div>
                        <div>
                              <!-- Create Mobile Money form here -->
                            <a href="#!" class="secondary-content momo right"  title="MTN Mobile Money">
                                <img src="{{URL::to('public/images')}}/mtnmomo.jpg" alt="Purchase with your Mobile Money Account" class="circle responsive" height="50" width="50" />
                            </a>
                        </div>
                    </div>
                    </div>
            </div>
            
            <div class="col m4 well">
            </div>
        </div>
@stop
