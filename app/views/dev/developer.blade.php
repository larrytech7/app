@extends('layouts.default')

@section('content')
        <!-- Heading Row -->
        
        <div class="row">
            <div class="col-md-8">
                <h5> Developer | Merchant</h5>
                <div class="col s12 m3 ">
                    <div class="collection">
                        <a class="collection-item blue-text" href="{{URL::route('home')}}"><i class="material-icons">home</i> Home</a>
                        <a class="active collection-item blue" href="{{URL::route('developer')}}"><i class="material-icons">supervisor_account</i> Accounts</a>
                        <a href="#apidocs" class="collection-item blue-text"><i class="material-icons">inbox</i>API Docs</a>
                        <a href="#support" class="collection-item blue-text"><i class="material-icons">forum</i>API Support</a>
                    </div>
                </div>
                <div class="col s12 m9">
                    Accounts <span><a class="modal-trigger" href="#merchantaccount"><i class="material-icons">add_circle</i> New Account</a></span>
                    
                    <table class="table table-condensed table-hover">
                                <th>Username</th>
                                <th>Payment Provider</th>
                                <th>API_KEY</th>
                                <th>Status</th>
                                <th>Action</th>
                        @foreach($developers as $developer)
                              <tr>
                                
                                  <td>{{ $developer->dev_username }}</td>
                                  <td>{{ $developer->dev_paymentprovider }}</td>
                                  <td>{{ $developer->dev_key }}</td>
                                  <td>{{ $developer->status == 0? 'sandbox':'live' }}</td>
                                  <td>
                                    <a href="{{ URL::route('developer').'?ac=rm&id='.$developer->dev_key }}" class="red-text" title="Delete account"><i class="material-icons">delete</i></a>
                                    <a href="{{ URL::route('developer').'?ac=st&id='.$developer->dev_key }}" class="green-text" title="Activate or Deactivate account" ><i class="material-icons">swap_horiz</i></a>
                                    <a href="{{ URL::route('developer').'?ac=gen&id='.$developer->dev_key }}" class="blue-text" title="Generate Payment Button"><i class="material-icons">autorenew</i></a>
                                  </td>
                                </tr>
                        @endforeach
                    </table>
                    <form action="{{URL::to('sandbox/api/merchantapi')}}" method="post" name="merchant_form">
                        <input type="hidden" name="apikey" value="xxxxx"/>
                        <input type="hidden" name="currency" value="USD"/>
                        <input type="hidden" name="amount" value="20"/>
                        <input type="hidden" name="return_url" value="http://mysite.com/checkout" />
                        <input type="hidden" name="payprovider" value="mobilemoney"/>
                        <input type="hidden" name="cdata1" value="xxxxx"/>
                        <input type="hidden" name="cdata2" value="xxxxx"/>
                        <input type="image" src="{{URL::to('public/images/hybopay_checkout.png')}}" width="150" height="80"/>
                    </form>
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
       
 <!-- new merchant account Modal Structure -->
          <div id="merchantaccount" class="modal ">
            <div class="modal-content">
              <h4>New Merchant Account</h4>
              {{Form::open(array('url'=>'merchant', 'class'=>'form-horizontal merchant', 'role'=>'form'))}}
                  
                  <div class="col s6 center-align">
                      <div class=" input-field col s12">
                            <i class="material-icons prefix blue-text lighten-4">account_circle</i>
                            <input type="text" id="merchantname" name="dev_username" required />
                            <label for="merchantname"> Merchant username</label>
                            <span class="alert-danger">{{ $errors->first('dev_username') }}</span>
                      </div>
                      <div class=" input-field col s12">
                            <i class="material-icons prefix blue-text lighten-4">phone</i>
                            <input type="tel" id="merchantphone" name="dev_phone" required />
                            <label for="merchantphone"> Phone number (international)</label>
                            <span class="alert-danger">{{ $errors->first('dev_phone') }}</span>
                      </div>
                      <div class=" input-field col s12">
                            <i class="material-icons prefix blue-text lighten-4">email</i>
                            <input type="email" id="merchantemail" name="dev_email" required />
                            <label for="merchantemail"> Email</label>
                            <span class="alert-danger">{{ $errors->first('dev_email') }}</span>
                      </div>
                        <div class="input-field col s12">
                            <select name="merhantprovider" id="merhantprovider">
                                <option selected="selected" value="paypal" class="left circle">PayPal</option>
                                <option value="solidtrustpay" class="left circle">Solid Trust Pay</option>
                                <option value="mobilemoney" class="left circle">Mobile Money</option>
                            </select>
                            <label><i class="material-icons grey-text tooltiped" data-position="right" data-delay="50" data-tooltip="The Payment provider to deposit funds in. Enter the corresponding phone, email or username to be used above.">info</i>Merchant Provider</label>
                        </div>
                      <div class="center-align">
                        <button class="btn-flat btn-primary waves-effect waves-white" type="submit"> Create</button>
                       <button type="button" class="modal-action modal-close waves-effect waves-green btn-flat btn-danger">Cancel</button>
                        {{Form::token()}}
                        {{Form::close()}}                    
                      </div>
                  </div>
                  
            </div>
          </div>
 <!-- end modal -->

@stop