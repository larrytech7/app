@extends('layouts.default')

@section('content')
        <!-- Heading Row -->
        <div class="row">
            <div class="col-md-8">
                <div class="col s12 m3 ">
                    <div class="collection">
                        <a class="collection-item blue active" href="{{URL::route('home')}}">
                            <i class="material-icons left ">home</i>Home
                        </a>
                        <a class="collection-item blue-text modal-trigger" href="#modal1" >
                            <i class="material-icons left green-text darken-5">payment</i>New Transaction
                        </a>
                        <a href="{{URL::route('dashboard.transaction')}}" class="collection-item blue-text">
                            <i class="material-icons left brown-text lighten-1">assignment</i>History
                        </a>
                        <a href="#" class="opt collection-item blue-text" >
                            <i class="material-icons left yellow-text lighten-1">flash_on</i>Invoices
                        </a>
                        <a href="#" class="collection-item blue-text" >
                            <i class="material-icons left teal-text lighten-1">settings</i>Settings
                        </a>
                        <a class="collection-item blue-text" href="{{URL::route('developer')}}">
                            <i class="material-icons left">business</i> Merchant
                        </a>
                        <a href="#apidocs" class="opt collection-item blue-text">
                            <i class="material-icons left">inbox</i>API Docs
                        </a>
                        <a href="#support" class="opt collection-item blue-text ">
                            <i class=" material-icons left">forum</i>API Support
                        </a>
                    </div>
                </div>
                <div class="col s12 m9">
                <div class="slider demoslider"> <!-- Start slider -->
                <ul class="slides">
                    <li>
                        <img src="{{URL::to('public/images')}}/payments.jpg" alt="Payment via mobilemoney" class="responsive-img"/>
                        <div class="caption center-align">
                            <h3 class="black-text">Make a Payment</h3>
                            <h5 class="">Pay freelancers or remote collaborators easily in few clicks.</h5>
                            <p class="col s10 m10 l12 "> Click &laquo;New Transaction&raquo; </p>
                        </div>
                    </li>
                    <li>
                        <img src="{{URL::to('public/images')}}/sendmoney.jpg" alt="send money between accounts" class="responsive-img"/>
                        <div class="caption center-align">
                            <h3 class="black-text">Send Money</h3>
                            <h5 class="">Send money to areas between different platforms we integrate.</h5>
                            <p class="col s10 m10 l12 black-text"> Click &laquo;New Transaction&raquo;</p>
                        </div>
                    </li>
                    <li>
                        <img src="{{URL::to('public/images')}}/transaction_history.jpg" alt="View Transaction history" class="responsive-img"/>
                        <div class="caption right-align">
                            <h3 class="teal-text">Transaction History</h3>
                            <h5 class="teal-text">Properly organized history.</h5>                   
                            <p class="col s10 m10 l12 black-text"> Click &laquo;History&raquo; to view your latest transactions.</p>
                        </div>
                    </li>
                    <li>
                        <img src="{{URL::to('public/images')}}/invoice.jpg" alt="View invoices" class="responsive-img"/>
                        <div class="caption left-align">
                            <h3 class="black-text">Invoices</h3>
                            <h5 class="black-text">Create invoices as easy as possible.</h5>                            
                            <p class="col s10 m10 l12 black-text "> Click &laquo;Invoices&raquo; to view them</p>
                        </div>
                    </li>
                </ul>
            </div> <!-- End slider -->
            </div>
                <!-- How it works -->
                <div class="">
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
                            <h3>{{$user->username}}</h3><!-- 
                            <p class="red-text"><b>NOTE:</b> TO SEND MONEY USING YOUR VISA CARD, MASTERCARD OR ANY OTHER CREDIT CARD, SELECT &QUOT;<b>EWAY</b>&QUOT; AS YOUR PAYMENT PROVIDER AND YOUR AMOUNT WILL BE CONVERTED TO &QUOT;<b>AUD</b>&QUOT;</p>                            
                            -->
                        </div>                        
                 </div>
                 <div id="currencyconvert" >
                    <p class="align-center"><h4>Currency Converter</h4></p>
                    <div class="input-field col s6">
                            <select class="" name="from" id="from">
                                <option selected="selected" value="USD">USD - US Dollars</option>
                                <option value="EUR">EUR - Euros</option>
                                <option value="GBP">GBP - Bristish Pounds</option>
                                <option value="XAF">FCFA - Franc CFA</option>
                                <option value="ZAR">South African Rand</option>
                                <option value="AUD">AUD - Australlian </option> <!-- CAD  and JPY conversions coming soon! -->
                            </select>
                            <label for="from">FROM</label>
                      </div>
                      <div class="input-field col s6">
                            <select class="" name="to" id="to">
                                <option selected="selected" value="USD">USD - US Dollars</option>
                                <option value="EUR">EUR - Euros</option>
                                <option value="GBP">GBP - Bristish Pounds</option>
                                <option value="XAF">FCFA - Franc CFA</option>
                                <option value="ZAR">South African Rand</option>
                                <option value="AUD">AUD - Australlian </option>
                                <option value="CAD">CAD - Canadian </option>
                                <option value="JPY">Japanese Yen</option>
                            </select>
                            <label for="to">TO</label>
                      </div>
                      <span class="result blue-text"></span>
                      <div class="preloader-wrapper small cloader hide">
                        <div class="spinner-layer spinner-green-only">
                          <div class="circle-clipper left">
                            <div class="circle"></div>
                          </div><div class="gap-patch">
                            <div class="circle"></div>
                          </div><div class="circle-clipper right">
                            <div class="circle"></div>
                          </div>
                        </div>
                      </div>
                      <div class="input-field col s12">
                        <i class="material-icons prefix blue-text">attach_money</i>
                        <input type="number" name="amountc" id="amountc" onkeyup="convert()" min="1"/>
                        <label for="amountc">Amount to Convert</label>
                      </div>
                 </div>
                 <div class="card col s12">
                    
                    <table class="table table-bordered">
                        <thead><h4>Transfer Limits</h4></thead>
                        <th>
                            <td>FROM</td>
                            <td>TO</td>
                            <td>AMOUNT</td>
                        </th>
                        <tr>
                            <td></td>
                            <td>*</td>
                            <td>Mobile Money</td>
                            <td>500000 FCFA</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>*</td>
                            <td>PayPal</td>
                            <td>$ 5000</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>*</td>
                            <td>Skrill</td>
                            <td>$ 5000</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>*</td>
                            <td>Solid Trust Pay</td>
                            <td>$ 5000</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>*</td>
                            <td>Eway</td>
                            <td>$ 5000</td>
                        </tr>
                    </table>
                 </div>
                
            </div>
            <!-- /.col-md-4 -->
        </div>
        <!-- /.row -->
        <!-- options row -->
        <div class="row">
                <ul id="optionsmenu" class="dropdown-content">
                  <li><a href="{{URL::route('developer')}}">Developer</a></li>
                  <li class="divider"></li>
                  <li><a class="opt" href="#!">Settings</a></li>
                </ul>
        </div>
 <!-- apyment Modal Structure -->
          <div id="modal1" class="modal ">
            <div class="modal-content">
              <h4>New Transaction</h4>
              {{Form::open(array('url'=>'payment', 'class'=>'form-horizontal payment', 'role'=>'form'))}}
                  <div class="row">
                  <div class="col s12 m6">
                    <h5>Transaction Info</h5>
                      <div class=" input-field col s12">
                            <i class="material-icons prefix blue-text lighten-4">attach_money</i>
                            <input type="number" id="amount" name="amount" min="1" required />
                            <label for="number"> Amount to send</label>
                      </div>
                      <div class="input-field col s12" id="currency">
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
                        <div class="input-field col s12">
                            <select class="pmode" name="mode" id="mode">
                                <option selected="selected" value="pp" class="left circle">PayPal</option>
                                <option value="stp" class="left circle">Solid Trust Pay</option>
                                <option value="sk" class="left circle">Skrill</option>
                                <option value="mm" class="left circle">Mobile Money</option>
                                <option value="ew" class="left circle">eWay</option>
                                <option value="cc" class="left circle">Credit/Debit Card</option>
                            </select>
                            <label><i class="material-icons grey-text tooltiped" data-position="right" data-delay="50" data-tooltip="This is the method of transfer you currently/actively use. Make sure you have a valid account with the provider">info</i>Sender Provider</label>
                        </div> <!-- cc Detail section -->
                        <div class="hide creditcard">
                            <div class="input-field col s7">
                                <i class="material-icons prefix blue-text lighten-4">credit_card</i>
                                <input type="number" id="cardnumber" name="cardnumber" min="1"/>
                                <label for="cardnumber">Card Number</label>
                            </div>
                            <div class="input-field col s2">
                                <input type="number" id="cvv" name="cvv" min="1"/>
                                <label for="cvv">CVV</label>
                            </div>
                            <div class="input-field col s3">
                                <select class="cctype" name="cctype" id="cctype">
                                    <option selected="selected" value="visa" class="left circle">VISA</option>
                                    <option value="mastercard" class="left circle">MASTERCARD</option>
                                    <option value="discover" class="left circle">Discover</option>
                                    <option value="maestro" class="left circle">Maestro</option>
                                </select>
                            </div>
                            <div class="input-field col s12">
                                <i class="material-icons prefix blue-text lighten-4">today</i>
                                <input type="month" id="expire" name="expire" />
                                <label for="expire">Card Expiry Date</label>
                            </div>
                            
                            <div class="input-field col s6">
                                <i class="material-icons prefix blue-text lighten-4">account_circle</i>
                                <input type="text" id="fname" name="fname" />
                                <label for="fname">First Name</label>
                            </div>
                            <div class="input-field col s6">
                                <i class="material-icons prefix blue-text lighten-4">account_circle</i>
                                <input type="text" id="lname" name="lname" />
                                <label for="lname">Last Name</label>
                            </div>
                        </div>
                        <!-- CC detail end -->
                  </div>
                  <div class="col s12 m6">
                    <h5>Receiver Info </h5>
                    <div class="input-field col s12">
                              <i class="material-icons prefix blue-text lighten-4">person</i>
                              <input type="text" id="number" name="number" required />
                                <label for="number">Receiver(name,number,email)</label>
                              <input type = "hidden" name = "testmode" value = "1" />
                    </div>
                    <div class="input-field col s12">
                              <i class="material-icons prefix blue-text lighten-4">email</i>
                              <input type="email" id="remail" name="remail" required />
                                <label for="number">email</label>
                    </div>
                    <div class="input-field col s12">
                            <select class="target" name="target" id="target" required="required">
                                <option value="" disabled selected >Select Receiver Platform</option>
                                <option value="pp" class="left circle">PayPal</option>
                                <option value="stp" class="left circle">Solid Trust Pay</option>
                                <option value="sk" class="left circle">Skrill</option>
                                <option value="mm" class="left circle">Mobile Money</option>
                                <option value="ew" class="left circle">eWay</option>
                            </select>
                            <label><i class="material-icons grey-text tooltiped" data-position="right" data-delay="50" data-tooltip="This is the account through which the receiver can receive money. Make sure the receiver's account is currently active on the platform">info</i>Receiver Provider</label>
                     </div>
                     <div class="right">
                        <button type="button" class="modal-action modal-close waves-effect waves-green btn-flat btn-danger">Close</button>
                        <button type="submit" class="btn-flat btn-primary waves-effect waves-white"><i class="material-icons right">send</i>Continue</button>                        
                    </div>
                    <div id="stp">
                        <input type="hidden" name="merchantAccount" value="larryakah" />
                        <input type="hidden" name="item_id" value="STP Hybrid Transfer" />
                        <input type="hidden" name="confirm_url" value="{{URL::route('dashboard')}}/stpconfirm" />
                        <input type="hidden" name="testmode" value="on" />
                        <input type="hidden" name="notify_url" value="{{URL::route('dashboard')}}/stpnotif" />
                        <input type="hidden" name="return_url" value="{{URL::route('dashboard')}}" />
                        <input type="hidden" name="cancel_url" value="{{URL::route('dashboard')}}/cancel" />
                        <input type="hidden" name="user1" value="xx" id="user1" /> <!-- receiver email, number etc set by js -->
                        <input type="hidden" name="user2" value="xx" id="user2" /><!-- receiver's payment provider -->
                    </div>
                    {{Form::token()}}
                    {{Form::close()}}                    
                  </div>
                  </div>
                       
                  <div class="row">
                    <div class="col s12 black-text">
                        Your account will be debited including the applicable Tax and platform charges as reflected on your Provider's account.                        
                    </div>
                  </div>
             
            </div>
           
          </div>
 <!-- end modal -->

@stop