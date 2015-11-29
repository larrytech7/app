@extends('layouts.default')

@section('content')
<!-- Heading Row -->
        <div class="row">
            
        </div> <br />

        <!-- Heading Row -->
        <div class="row">
            <div class="col-md-8">
                <div class="slider demoslider"> <!-- Start slider -->
                <ul class="slides">
                    <li>
                        <img src="{{URL::to('public/images')}}/payments.jpg" alt="Payment via mobilemoney" class="responsive-img"/>
                        <div class="caption center-align">
                            <h3 class="black-text">Make a Payment</h3>
                            <h5 class="">Pay freelancers or remote collaborators easily in few clicks.</h5>
                            <p class="col s10 m10 l12 "> Click &laquo;Make payment&raquo; Below</p>
                        </div>
                    </li>
                    <li>
                        <img src="{{URL::to('public/images')}}/sendmoney.jpg" alt="send money between accounts" class="responsive-img"/>
                        <div class="caption center-align">
                            <h3 class="black-text">Send Money</h3>
                            <h5 class="">Send money to areas supporting any platforms we integrate.</h5>
                            <p class="col s10 m10 l12 black-text"> Click &laquo;Send money&raquo; Below</p>
                        </div>
                    </li>
                    <li>
                        <img src="{{URL::to('public/images')}}/transaction_history.jpg" alt="View Transaction history" class="responsive-img"/>
                        <div class="caption right-align">
                            <h3 class="teal-text">Transaction History</h3>
                            <h5 class="teal-text">We keep track of your account transactions.</h5>                   
                            <p class="col s10 m10 l12 black-text"> Click &laquo;History&raquo; to view your latest transactions.</p>
                        </div>
                    </li>
                    <li>
                        <img src="{{URL::to('public/images')}}/invoice.jpg" alt="View invoices" class="responsive-img"/>
                        <div class="caption left-align">
                            <h3 class="black-text">Invoices</h3>
                            <h5 class="black-text">Your invoices all in one place. Stay most organised.</h5>                            
                            <p class="col s10 m10 l12 black-text "> Click &laquo;Invoices&raquo; to view them</p>
                        </div>
                    </li>
                </ul>
            </div> <!-- End slider -->
            <div class=" blue lighten-1">
                    <a class="waves-effect waves-teal btn-flat btn modal-trigger" href="#modal1" >
                            <i class="material-icons left green-text darken-5">payment</i>Make Payment
                    </a>|
                    <a href="#" class="waves-effect waves-blue btn-flat btn" data-toggle="modal" data-target="#mm2pp">
                          <i class="material-icons left red-text lighten-1">send</i>Send Money
                    </a>|
                    <a href="{{URL::route('dashboard.transaction')}}" class="waves-effect waves-green btn-flat btn">
                            <i class="material-icons left brown-text lighten-1">assignment</i>History
                    </a>|
                    <a href="#" class="btn waves-effect waves-red btn-flat">
                            <i class="material-icons left yellow-text lighten-1">flash_on</i>Invoices
                    </a>|
                    <a href="#" class="btn waves-effect waves-red btn-flat">
                            <i class="material-icons left teal-text lighten-1">settings</i>Options
                    </a>
                </div>

            </div>
            <!-- /.col-md-8 -->
            <div class="col-md-4 well">
                    <div class="media">
                            <div class="media-body">
                              <h3 class="media-heading">{{$user->username}}</h3>
                               <br />
                              <table class="table table-condensed table-hover" >
                              <tr>
                                <td>Email</td>
                                <td>{{$user->email}}</td>
                              </tr>
                              <tr>
                                <td>Phone</td>
                                <td>{{$user->number}}</td>
                              </tr>
                              <tr>
                                <td>Country</td>
                                <td>{{$user->country}}</td>
                              </tr>
                              </table>
                            </div>
                        </div>
                    <br />
                </div> 
                
            </div>
            <!-- /.col-md-4 -->
        </div>
        
         <!-- apyment Modal Structure -->
          <div id="modal1" class="modal bottom-sheet">
            <div class="modal-content">
              <h4>Make Payment</h4>
              {{Form::open(array('url'=>'payment', 'class'=>'form-horizontal payment', 'role'=>'form'))}}
                  <div class="row">
                      <div class="input-field col s4">
                              <i class="material-icons prefix blue-text lighten-4">person</i>
                              <input type="text" id="number" name="number" required />
                                <label for="number">Receiver(Name/number)</label>
                              <input type = "hidden" name = "testmode" value = "1" />
                      </div>
                      <div class=" input-field col s4">
                            <i class="material-icons prefix blue-text lighten-4">attach_money</i>
                            <input type="number" id="amount" name="amount" min="10" required />
                            <label for="number"> Amount to send</label>
                      </div>
                      <div class="input-field col s4" id="currency">
                            <select class="" name="currency">
                                <option selected="selected" value="USD">USD - US Dollars</option>
                                <option value="EUR">EUR - Euros</option>
                                <option value="GBP">GBP - Bristish Pounds</option>
                            </select>
                            <label>Currency</label>
                      </div>
                      
                  </div>
                  <div class="row">
                        <div class="input-field col s4">
                            <select class="icons pmode" name="mode" id="mode">
                                <option selected="selected" value="pp" data-icon="{{URL::to('public/images')}}/ic_pp.jpg" class="left circle">PayPal</option>
                                <option value="stp" data-icon="{{URL::to('public/images')}}/ic_stp.JPG" class="left circle">Solid Trust Pay</option>
                                <option value="sk" data-icon="{{URL::to('public/images')}}/ic_sk.jpg" class="left circle">Skrill</option>
                                <option value="mm" data-icon="{{URL::to('public/images')}}/ic_sk.jpg" class="left circle">Mobile Money</option>
                                <option value="ew" data-icon="{{URL::to('public/images')}}/ic_sk.jpg" class="left circle">eWay</option>
                            </select>
                            <label><i class="material-icons grey-text tooltiped" data-position="right" data-delay="50" data-tooltip="This is the method of transfer you currently/actively use. Make sure you have a valid account with the provider">info</i>Sender Provider</label>
                        </div>
                        <div class="input-field col s4">
                            <select class="icons target" name="target" id="target">
                                <option selected="selected" value="pp" data-icon="{{URL::to('public/images')}}/ic_pp.jpg" class="left circle">PayPal</option>
                                <option value="stp" data-icon="{{URL::to('public/images')}}/ic_stp.JPG" class="left circle">Solid Trust Pay</option>
                                <option value="sk" data-icon="{{URL::to('public/images')}}/ic_sk.jpg" class="left circle">Skrill</option>
                                <option value="mm" data-icon="{{URL::to('public/images')}}/ic_sk.jpg" class="left circle">Mobile Money</option>
                                <option value="ew" data-icon="{{URL::to('public/images')}}/ic_sk.jpg" class="left circle">eWay</option>
                            </select>
                            <label><i class="material-icons grey-text tooltiped" data-position="right" data-delay="50" data-tooltip="This is the account through which the receiver can receive the money. Make sure the receiver's account is currently active on the platform">info</i>Receiver Provider</label>
                        </div>
                        <div class="col s4">
                            <button type="submit" class="btn-flat btn-primary waves-effect waves-white"><i class="material-icons right">send</i>Continue</button>
                            <button type="button" class="modal-action modal-close waves-effect waves-green btn-flat btn-danger">Close</button>&nbsp;&nbsp;
                        </div>
                  </div>
                  <div class="row">
                    <div class="col s6 black-text">
                        Your account will be debited including the applicable Tax and platform charges as reflected on your Provider's account.                        
                    </div>
                    <div id="stp">
                        <input type="hidden" name="merchantAccount" value="larryakah" />
                        <input type="hidden" name="item_id" value="STP Hybrid Transfer" />
                        <input type="hidden" name="confirm_url" value="{{URL::route('dashboard')}}/stpconfirm" />
                        <input type="hidden" name="testmode" value="on" />
                        <input type="hidden" name="notify_url" value="{{URL::route('dashboard')}}/stpnotif" />
                        <input type="hidden" name="return_url" value="{{URL::route('dashboard')}}" />
                        <input type="hidden" name="cancel_url" value="{{URL::route('dashboard')}}/cancel" />
                    </div>
                    
                  </div>
              {{Form::token()}}
            {{Form::close()}}
            </div>
          </div>
 <!-- end modal -->
@stop
