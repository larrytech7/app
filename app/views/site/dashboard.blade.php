@extends('layouts.default')

@section('content')
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
                            <i class="material-icons left green-text darken-5">payment</i>New Transaction
                    </a>|
                    <!--
                    <a href="#" class="waves-effect waves-blue btn-flat btn" data-toggle="modal" data-target="#mm2pp">
                          <i class="material-icons left red-text lighten-1">send</i>Send Money
                    </a>|
                    -->
                    <a href="{{URL::route('dashboard.transaction')}}" class="waves-effect waves-green btn-flat btn">
                            <i class="material-icons left brown-text lighten-1">assignment</i>History
                    </a>|
                    <a href="#" class="btn waves-effect waves-red btn-flat">
                            <i class="material-icons left yellow-text lighten-1">flash_on</i>Invoices
                    </a>|
                    <a href="#" class="btn waves-effect waves-red btn-flat dropdown-button" data-activates="optionsmenu">
                            <i class="material-icons left teal-text lighten-1">settings</i>Options
                    </a>
                </div>
            </div>
            <!-- /.col-md-8 -->
            <div class="col-md-4">
                <div class="flip-card active-card full-card" >
                        <div class="pcard label-info">
                            <a href=""><img class=" img-circle text-center" src="{{URL::to('public/images')}}/user.jpg"/></a>
                        </div>
                        
                        <!--<a href="{{URL::to('dashboard/account/manage/'.Auth::user()->id.'/modify')}}" class="btn btn-primary btn-fab btn-raised " id="first" title="View User Account">-->
                        <a href="{{URL::route('viewprofile')}}" class="btn btn-primary btn-fab btn-raised " id="first" title="View User Account">
                            <span class="glyphicon glyphicon-user"></span>
                        </a>
                        <div class="well">
                            <h3>{{$user->username}}</h3>                            
                        </div>                        
                 </div>
            </div>
            <!-- /.col-md-4 -->
        </div>
        <!-- /.row -->
        <!-- options row -->
        <div class="row">
            <div class="col s8">
                <p><h2>How it works </h2></p>
                   <div class="col s12 m4">
                        <div class="icon-block">
                            <h2 class="center green-text">
                                <img src="{{URL::to('public/images')}}/one.png" alt="View invoices" class="responsive-img"/>
                            </h2>
                            <h5 class="center">Send money/payment</h5>
                            <p class="light center-align">Click 'new transaction' and enter receiver's information appropriately as requested.</p>
                        </div>
                   </div>
                   <div class="col s12 m4">
                        <div class="icon-block">
                            <h2 class="center green-text">
                                <img src="{{URL::to('public/images')}}/two.png" alt="View invoices" class="responsive-img"/>
                            </h2>
                            <h5 class="center">Select Portal</h5>
                            <p class="light center-align">Select you payment provider and your receipient's payment provider.</p>
                        </div>
                   </div>
                   <div class="col s12 m4">
                        <div class="icon-block">
                            <h2 class="center green-text">
                                <img src="{{URL::to('public/images')}}/three.png" alt="View invoices" class="responsive-img"/>
                            </h2>
                            <h5 class="center">Continue transaction</h5>
                            <p class="light center-align">Once redirected to your payment provider, login and validate the transaction.</p>
                        </div>
                   </div>
               <p> Once these steps are complete, you would receive an email containing the transaction receipt and your receipient would be notified of the transaction.
               You may also check in the history here to make sure your transaction has been recorded with us.
               </p>
               <br />
               
                <div class="card-panel grey lighten-4 responsive">
                    <h5>No Promotions Yet.</h5>
                </div>
                
            </div>
            <div class="col s4">
                 <div class="card-panel grey lighten-4 responsive">
                    <aside>&QUOT;With hybrid transfers, everybody can play the game.&QUOT;</aside>- Larry Akah
                </div>
                <div class="card-panel grey lighten-4 responsive">
                              <h5>Adverts</h5>
                </div>
            </div>
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
                                <label for="number">Receiver(name,number,email)</label>
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
                                <option value="XAF"> FCFA - Franc CFA</option>
                                <option value="ZAR">South African Rand</option>
                                <option value="AUD">AUD - Australlian </option>
                                <option value="CAD">CAD - Canadian </option>
                                <option value="JPY">Japanese Yen</option>
                            </select>
                            <label>Currency</label>
                      </div>
                      
                  </div>
                  <div class="row">
                        <div class="input-field col s4">
                            <select class=" pmode" name="mode" id="mode">
                                <option selected="selected" value="pp" class="left circle">PayPal</option>
                                <option value="stp" class="left circle">Solid Trust Pay</option>
                                <option value="sk" class="left circle">Skrill</option>
                                <option value="mm" class="left circle">Mobile Money</option>
                                <option value="ew" class="left circle">eWay</option>
                            </select>
                            <label><i class="material-icons grey-text tooltiped" data-position="right" data-delay="50" data-tooltip="This is the method of transfer you currently/actively use. Make sure you have a valid account with the provider">info</i>Sender Provider</label>
                        </div>
                        <div class="input-field col s4">
                            <select class="target" name="target" id="target" required="required">
                                <option value="" disabled selected >Select Receiver Platform</option>
                                <option value="pp" class="left circle">PayPal</option>
                                <option value="stp" class="left circle">Solid Trust Pay</option>
                                <option value="sk" class="left circle">Skrill</option>
                                <option value="mm" class="left circle">Mobile Money</option>
                                <option value="ew" class="left circle">eWay</option>
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
                        <input type="hidden" name="user1" value="xx" id="user1" /> <!-- receiver emial, number etc set by js -->
                        <input type="hidden" name="user2" value="xx" id="user2" /><!-- receiver's payment system-->
                    </div>
                    
                  </div>
              {{Form::token()}}
            {{Form::close()}}
            </div>
          </div>
 <!-- end modal -->
        <!-- modal for mobile money to paypal transaction -->
        <div class="modal fade" id="mm2pp">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Mobile Money To Paypal Transfer</h4>
              </div>
              <div class="modal-body">
                {{Form::open(array('url'=>'transfer', 'class'=>'form-horizontal', 'role'=>'form'))}}
                  <div class="row">
                      <div class="col-xs-6">
                          <div class="input-group">
                              <span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></span>
                              <input type="email" id="email" name="email" class="form-control" placeholder="recipient paypal email" required>
                          </div>
                      </div>
                      <div class="col-xs-6">
                          <div class="input-group">
                              <input type="number" id="amount" name="amount" min="5000" class="form-control" placeholder="Amount " required>
                              <span class="input-group-addon">FCFA</span>
                          </div>
                      </div>
                      
                  </div>
              
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Continue</button>
              </div>
              {{Form::token()}}
              {{Form::close()}}
            </div><!-- /.modal-content -->
          </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

        <!-- modal for paypal to mobile money -->
        <div class="modal fade" id="pp2mm">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Paypal To Mobile Money</h4>
              </div>
              <div class="modal-body">
                {{Form::open(array('url'=>'payment', 'class'=>'form-horizontal', 'role'=>'form'))}}
                  <div class="row">
                      <div class="input-field col s6">
                              <i class="material-icons prefix blue-text lighten-4">phone</i>
                              <input type="number" id="number" name="number" min="600000000" required>
                                <label for="number">Receiver Phone number</label>
                      </div>
                      <div class=" input-field col s6">
                            <i class="material-icons prefix blue-text lighten-4">attach_money</i>
                            <input type="number" id="amount" name="amount" min="10" required />
                            <label for="number"> Amount to send</label>
                      </div>
                  </div>
                  <div class="row">
                      <div class="input-field col s6" id="currency">
                          <!-- <label for="name">Country</label> -->
                            <select class="" name="currency">
                                <option selected="selected" value="USD">USD - US Dollars</option>
                                <option value="EUR">EUR - Euros</option>
                                <option value="GBP">GBP - Bristish Pounds</option>
                            </select>
                            <label>Currency</label>
                    </div>
                    <div class="col s6 black-text">
                        Your account will be debited including the applicable Tax and platform charges as reflected on your paypal.                        
                    </div>
                      
                  </div>
              
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Continue</button>
              </div>
              {{Form::token()}}
              {{Form::close()}}
              <ul id="optionsmenu" class="dropdown-content">
                  <li><a href="#!">Developers</a></li>
                  <li class="divider"></li>
                  <li><a href="#!">Settings</a></li>
            </ul>
            </div><!-- /.modal-content -->
          </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
@stop