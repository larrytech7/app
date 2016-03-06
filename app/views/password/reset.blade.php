@extends('layouts.default')

@section('content')
    <!-- Heading Row -->
        <div class="row">
            
            <!-- /.col-md-8 -->
            <div class="module module-login col-md-4 offset4 well">

            <!-- <div class="module module-login span4 offset4"> -->

                <h3 id="pad">Reset Password</h3>
                <div class="center-align">
                    <img src="{{URL::to('public/images')}}/logo.png" alt="Izepay Logo" height="200" width="300"/>
                </div>
                    @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade in" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <strong>{{ implode('', $errors->all('<p>:message</p>')) }}</strong>
                    </div>
                    @endif 
                {{Form::open(array('url'=>'recovery', 'class'=>'form-horizontal', 'role'=>'form'))}}
                    <input type="hidden" name="special"  value="{{$user->id}}" />
                    <div class="form-group">
                        <div class="col-sm-12">
                            <input type="password" name="new_password" class="form-control" placeholder=" New Password">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <input type="password" name="confirm_new_password" class="form-control" placeholder="Confirm New Password">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12 center-align">
                            <button type="submit" class="waves-effect waves-light blue btn-flat">Reset</button>
                        </div>
                    </div>
                    {{Form::token()}}
                {{Form::close()}}

            </div>
            <!-- /.col-md-4 -->
        </div>
@stop
