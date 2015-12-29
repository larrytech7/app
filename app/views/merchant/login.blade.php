@extends('layouts.default')

@section('content')
<!-- Heading Row -->
        <div class="row">
            <div class="col s4 "></div>
            <!-- /.col-md-8 -->
            <div class="col s12 m4 well offset-l4">
                <div class="center-align">
                    <img class="responsive-img" src="{{URL::to('public/images')}}/logo.png" alt="HyboPay Logo" style="height:150px;width:200px"/>
                </div>
                <h3 id="pad" class="center"> Login</h3>
                    @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade in" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <strong>{{ implode('', $errors->all('<p>:message</p>')) }}</strong>
                    </div>
                    @endif 
                {{Form::open(array('url'=>'sandbox/api/merchantapi/login', 'class'=>'form-horizontal', 'role'=>'form'))}}
                    <div class="form-group">
                        <div class="col-sm-12">
                            <input id="username" type="text" name="username" class="form-control" value="{{ Input::old('username') }}" placeholder="Username" required />
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <input type="password" name="password" class="form-control" placeholder="Password" required="required" />
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <select name="payprovider" id="paymode">
                                <option value="pp">PayPal</option>
                                <option value="mm">MobileMoney</option>
                                <option value="stp">Solid TrustPay</option>
                            </select>
                            <label for="paymode">Choose your payment method</label>
                        </div>
                    </div>
                    <div>
                        <input type="hidden" name="apikey" value="{{Input::get('apikey')}}"/>
                        <input type="hidden" name="currency" value="{{Input::get('currency')}}"/>
                        <input type="hidden" name="amount" value="{{Input::get('amount')}}"/>
                        <input type="hidden" name="return_url" value="{{Input::get('return_url')}}" />
                        <input type="hidden" name="cdata1" value="{{Input::get('cdata1')}}"/>
                        <input type="hidden" name="cdata2" value="{{Input::get('cdata2')}}"/>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <a href="{{URL::route('home')}}">Don't have an account?</a>
                            <button type="submit" class="btn-flat blue right">Login to continue</button>
                        </div>
                    </div>
                    {{Form::token()}}
                {{Form::close()}}
            </div>
            <div class="col s4"></div>
            <!-- /.col-md-4 -->
        </div>
@stop
