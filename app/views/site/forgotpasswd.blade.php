@extends('layouts.default')

@section('content')
<!-- Heading Row -->
        <div class="row">
            
            <!-- /.col-md-8 -->
            <div class="module module-login col-md-4 offset4 well">
                <div class="center"><img class="img-circle img-responsive" src="{{URL::to('public/images')}}/logo.png" alt="IcePay Logo" height="180"/></div>
                <h3 id="pad" class="center"> Forgot Password</h3><hr>
                    @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade in" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <strong>{{ implode('', $errors->all('<p>:message</p>')) }}</strong>
                    </div>
                    @endif 
                {{Form::open(array('url'=>'forgotpasswd', 'class'=>'form-horizontal', 'role'=>'form'))}}
                    <p>Forgotten your password? Enter your email address below to begin the reset process.
                    </p>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <input id="email" type="text" name="email" class="form-control" value="{{ Input::old('email') }}" placeholder="Email" required />
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <button type="submit" class="btn-flat btn-success right">Send</button>
                        </div>
                    </div>
                    {{Form::token()}}
                {{Form::close()}}

            </div>
            <!-- /.col-md-4 -->
        </div>
@stop
