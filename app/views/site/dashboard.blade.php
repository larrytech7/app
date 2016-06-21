@extends('layouts.default')

@section('content')
        <!-- Heading Row -->
        <div class="row">
            <div class="col-md-9">
                <div class="col-sm-12 col-md-3 ">
                    <div class="collection" >
                        <a class="collection-item blue active" href="{{URL::route('home')}}">
                            <i class="material-icons left ">home</i>Home
                        </a>
                        <a class="collection-item blue-text modal-trigger" href="{{URL::route('send')}}" >
                            <i class="material-icons left blue-text darken-5">payment</i>Send payment
                        </a>
                        <a class="collection-item blue-text modal-trigger" href="{{URL::route('request')}}" >
                            <i class="material-icons left blue-text darken-5">play_for_work</i>Request payment
                        </a>
                        <a href="{{URL::route('dashboard.transaction')}}" class="collection-item blue-text">
                            <i class="material-icons left blue-text lighten-1">assignment</i>History
                        </a>
                        <a href="#" class="opt collection-item blue-text" >
                            <i class="material-icons left blue-text lighten-1">flash_on</i>Invoices
                        </a>
                        <a href="#" class="collection-item blue-text" >
                            <i class="material-icons left blue-text lighten-1">settings</i>Settings
                        </a>
                        <a class="collection-item blue-text" href="{{URL::route('developer')}}">
                            <i class="material-icons left">business</i> Merchant
                        </a>
                        <a href="{{URL::route('apidocs')}}" class="collection-item blue-text">
                            <i class="material-icons left">library_books</i>API Docs
                        </a>
                        <a href="{{URL::route('messagecenter')}}" class="collection-item blue-text">
                            <i class="material-icons left">comment</i>Message Center
                        </a>
                        
                    </div>
                </div>
                <div class="col-sm-12 col-md-9">
                <div class="slider demoslider"> <!-- Start slider -->
                <ul class="slides">
                    <li>
                        <img src="{{URL::to('public/images')}}/payments.jpg" alt="Payment via mobilemoney" class="responsive-img"/>
                        <div class="caption center-align">
                            <h3 class="black-text">Make a Payment</h3>
                            <h5 class="">Pay freelancers or remote collaborators easily in few clicks.</h5>
                            <p class="col s10 m10 l12 "> Click &laquo;Make payment&raquo; </p>
                        </div>
                    </li>
                    <li>
                        <img src="{{URL::to('public/images')}}/sendmoney.jpg" alt="send money between accounts" class="responsive-img"/>
                        <div class="caption center-align">
                            <h3 class="black-text">Send Money</h3>
                            <h5 class="">Send money to areas between different platforms we integrate.</h5>
                            <p class="col s10 m10 l12 black-text"> Click &laquo;Make payment&raquo;</p>
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
            <!-- how it works -->
            <div class="">
                <p ><h4 >How it works </h4></p>
                   <div class="col s12 m4">
                        <div class="icon-block">
                            <h2 class="center green-text">
                                <img src="{{URL::to('public/images')}}/one.png" alt="View invoices" class="circle" width="50" height="50"/>
                            </h2>
                            <h5 class="center">Send money/payment</h5>
                            <p class="light center-align">Click 'send payment' and enter receiver's information appropriately as requested.</p>
                        </div>
                   </div>
                   <div class="col s12 m4">
                        <div class="icon-block">
                            <h2 class="center green-text">
                                <img src="{{URL::to('public/images')}}/two.png" alt="View invoices" class="circle" width="50" height="50"/>
                            </h2>
                            <h5 class="center">Select Portal</h5>
                            <p class="light center-align">Select you payment provider and your receipient's payment provider.</p>
                        </div>
                   </div>
                   <div class="col s12 m4">
                        <div class="icon-block">
                            <h2 class="center green-text">
                                <img src="{{URL::to('public/images')}}/three.png" alt="View invoices" class="circle" width="50" height="50"/>
                            </h2>
                            <h5 class="center">Validate transaction</h5>
                            <p class="light center-align">Once redirected to your payment provider, authenticate the transaction.</p>
                        </div>
                   </div>
               <p> Once these steps are complete, you would receive an email of the transaction receipt and your receipient would be notified of the transaction.
               You may also check in the history here to make sure your transaction has been recorded with us.
               </p>
               <br />
               
            </div>
            <!-- end how it works -->
            </div>
            
            </div>
            <!-- /.col-md-8 -->
            <div class="col-md-3">
                <div class="flip-card active-card full-card" >
                        <div class="pcard label-info">
                            <a class="modal-trigger" href="#upload">
                                @if($user->photo == null)
                                <img class=" img-circle text-center" src="{{URL::to('public/images')}}/user.jpg"/>
                                @else
                                <img class=" img-circle text-center" src="{{URL::to('photo/'.$user->photo)}}"/>
                                @endif
                            </a>
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
                                <option value="ZAR">ZAR - South African Rand</option> 
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
                                <option value="ZAR">ZAR - South African Rand</option>
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
                            <td>FCFA 500000 </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>*</td>
                            <td>PayPal</td>
                            <td>USD 5000</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>*</td>
                            <td>Skrill</td>
                            <td>USD 5000</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>*</td>
                            <td>Solid Trust Pay</td>
                            <td>USD 5000</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>*</td>
                            <td>Eway/Credit Card</td>
                            <td>USD 5000</td>
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
 <!-- payment Modal Structure -->
          <div id="modal1" class="modal ">
            <div class="modal-content">
              <h4>New Transaction &nbsp;&nbsp;</h4>
              <span class="notifications hide">Processing</span>
              {{Form::open(array('url'=>'payment', 'class'=>'form-horizontal payment', 'role'=>'form', 'onsubmit'=>'sendpayment(event)'))}}
                  <div class="row">
                  <div class="col s12 m6">
                    <h5>Transaction Info</h5>
                    <input type="hidden" id="mynum" name="mynum" value="{{Auth::user()->number}}"/>
                      <div class=" input-field col s12">
                            <i class="material-icons prefix blue-text lighten-4">attach_money</i>
                            <input type="number" id="amount" name="amount" min="1" required />
                            <label for="number"> Amount to send</label>
                      </div>
                      <div class="input-field col s12" id="currency">
                            <select class="" name="currency" id="cur">
                                <option selected="selected" value="USD">USD - US Dollars</option>
                                <option value="EUR">EUR - Euros</option>
                                <option value="GBP">GBP - Bristish Pounds</option>
                                <option value="XAF"> FCFA - Franc CFA</option>
                                <option value="ZAR">ZAR - South African Rand</option>
                                <option value="AUD">AUD - Australlian </option>
                                <option value="CAD">CAD - Canadian </option>
                              <!--  <option value="JPY">Japanese Yen</option> -->
                            </select>
                            <label>Currency</label>
                      </div>
                        <div class="input-field col s12">
                            <select class="pmode" name="mode" id="mode">
                                <option selected="selected" value="pp" class="left circle">PayPal</option>
                                <option value="stp" class="left circle">Solid Trust Pay</option>
                               <!-- <option value="sk" class="left circle">Skrill</option> -->
                                <option value="mm" class="left circle">Mobile Money</option>
                                <option value="ew" class="left circle">eWay</option>
                               <!-- <option value="cc" class="left circle">Credit/Debit Card</option> -->
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
                              <input type="email" id="remail" name="remail" />
                              <label for="number">email</label>
                    </div>
                    <div class="input-field col s12">
                            <select class="target" name="target" id="target" required="required">
                                <option value="" disabled selected >Select Receiver Platform</option>
                                <option value="pp" class="left circle">PayPal</option>
                                <option value="stp" class="left circle">Solid Trust Pay</option>
                             <!--   <option value="sk" class="left circle">Skrill</option> -->
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

 <!-- Upload photo Modal Structure -->
          <div id="upload" class="modal ">
            <div class="modal-content">
              <h4>Upload Profile Photo</h4>
              {{Form::open(array('url'=>'uploadphoto', 'class'=>'form-horizontal', 'role'=>'form', 'enctype'=>'multipart/form-data'))}}
                  <div class="row">
                  <div class="col s12 m12">
                    <div class="file-field input-field">
                      <div class="btn">
                        <span>File</span>
                        <input type="file" name="photo">
                      </div>
                      <div class="file-path-wrapper">
                        <input class="file-path" type="text" name="photo" placeholder="Browse...">
                      </div>
                    </div>

                     <div class="right">
                        <button type="button" class="modal-action modal-close waves-effect waves-green btn-flat btn-danger">Close</button>
                        <button type="submit" class="btn-flat btn-primary waves-effect waves-white"><i class="material-icons right">send</i>Continue</button>                        
                    </div>
                    {{Form::token()}}
                    {{Form::close()}}                    
                  </div>
                  </div>
             
            </div>
           
          </div>
 <!-- end modal -->

@stop