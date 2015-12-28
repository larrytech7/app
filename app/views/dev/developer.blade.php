@extends('layouts.default')

@section('content')
        <!-- Heading Row -->
        <div class="row">
            <div class="col-md-8">
                <h5><i class="material-icons">code</i> Developer | Merchant</h5>
                <ul class="tabs">
                    <li class="tab col s4"><a class="active blue lighten-4" href="#accounts"><i class="material-icons">supervisor_account</i>Merchant Accounts</a></li>
                    <li class="tab col s4"><a href="#apidocs"><i class="material-icons">inbox</i>API Docs</a></li>
                    <li class="tab col s4"><a href="#support"><i class="material-icons">forum</i>API Support</a></li>
                </ul>
                <div id="accounts" class="col s12">Developer|merchant accounts</div>
                <div id="apidocs" class="col s12">API documentation</div>
                <div id="support" class="col s12">Service support</div>
            
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
                  <li><a class="opt" href="#!">Developers</a></li>
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