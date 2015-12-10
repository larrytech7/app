@extends('layouts.default')

@section('content')
<!-- Heading Row -->
        <div class="row">
            <video autoplay loop poster="{{URL::to('public/images')}}/logo.png" id="bgvid">
                <source src="{{$video_url}}" type="video/mp4" />
            </video>
            <button id="vidpause" class="btn-floating btn-large waves-effect waves-light red"><i class="material-icons">pause</i></button>
        </div>
        <div class="row center" style="margin-bottom: 28%;">
            <p class="center-align"><h2 class="white-text"> Make payments or send money accross the world.</h2></p>
            <p><h5 class="white-text">You now possess the power to pay freelancers more conviniently than ever before.</h5></p>
            <p></p>
            <br />
            <br />
            <a href="#signup" class="center-align waves-effect waves-teal btn-flat btn-large btn-primary"><i class="material-icons">person_pin</i>&nbsp;Signup freely </a>
        </div>
        <div class="row">
            <div class="col s12 m8 l8"> 
                <div class="card-panel responsive">
                    <h5 class="center-align">Money transfer/payments made simple in Africa and the world at large.</h5>                   
                </div>
                <div class="row">
                <div class="col s12 m4">
                  <div class="icon-block">
                    <h2 class="center green-text"><i class="material-icons large">flash_on</i></h2>
                    <h5 class="center">More opportunity</h5>
                    <p class="light">Conviniently pay freelancers worldwide. No need for new payment accounts. We do the heavy lifting.</p>
                  </div>
                </div>
        
                <div class="col s12 m4">
                  <div class="icon-block">
                    <h2 class="center blue-text"><i class="material-icons large">group</i></h2>
                    <h5 class="center">Smart Experience</h5>
        
                    <p class="light">Send money to users of different payment systems (Paypal, Skrill, Mobile Money etc) from your single account.</p>
                  </div>
                </div>
        
                <div class="col s12 m4">
                  <div class="icon-block">
                    <h2 class="center red-text lighten-5"><i class="material-icons large">settings</i></h2>
                    <h5 class="center">Developer zone</h5>
        
                    <p >Extend your e-commerce target market in simple steps by integrating our services.</p>
                  </div>
                </div>
              </div>
                <div class="row">
                    <div class="col s12 center" id="contact">
                      <i class="large material-icons green-text">perm_phone_msg</i>
                      <h4>Contact Us</h4>
                      <p><i class="material-icons prefix blue-text darken-3">location_on</i> &nbsp;Cameroon, Buea. FakoShip Plaza,<span> <b>Iceteck </b>Inc.</span> @ &nbsp;ActivSpaces</p>
                      <p><i class="material-icons prefix blue-text darken-3">phone</i> (+237) 678656032 | (+237) 677247206 </p>
                      <p><i class="material-icons prefix blue-text darken-3">email</i> <a href="mailto:larryakah@gmail.com" >service@iceteck.com</a> </p>
                    </div>
              </div>    
            </div>
            <!-- /.col-md-8 -->
            <div class="col well s12 m4 l4" id="signup">
                <h3 id="pad">Create Account</h3>
                {{Form::open(array('url'=>'register', 'class'=>'form-horizontal', 'role'=>'form'))}}
                
                    <div class="input-field col s12">
                        <i class="material-icons prefix blue-text lighten-4">account_circle</i>
                        <input id="icon_prefix" name="username" type="text" class="validate" required/>
                        <label for="icon_prefix">Username</label>
                         <span class="badge alert-danger">{{ $errors->first('username') }}</span>
                    </div>
                    <div class="input-field col s12">
                        <i class="material-icons prefix blue-text lighten-5">email</i>
                        <input id="icon_prefix" name="email" type="email" class="validate" required/>
                        <label for="icon_prefix">Email</label>
                         <span class="badge alert-danger">{{ $errors->first('email') }}</span>
                    </div>
                    <div class="input-field col s12">
                        <i class="material-icons prefix blue-text lighten-5">phone</i>
                        <input id="number" name="number" type="number" min="700000000"class="validate" required/>
                        <label for="number">Phone number</label>
                         <span class="badge alert-danger">{{ $errors->first('number') }}</span>
                    </div>
                    <div class="input-field col s12">
                        <i class="material-icons prefix blue-text lighten-4">lock_open</i>
                        <input id="password" name="password" type="password" class="validate" required/>
                        <label for="password">Password</label>
                         <span class="badge alert-danger">{{ $errors->first('password') }}</span>
                    </div>
                    <div class="input-field col s12">
                        <i class="material-icons prefix blue-text lighten-4">lock</i>
                        <input id="confirm_password" name="confirm_password" type="password" class="validate" required/>
                        <label for="confirm_password">Confirm Password</label>
                         <span class="badge alert-danger">{{ $errors->first('confirm_password') }}</span>
                    </div>
                
                <div class="input-field col s12">
                    <i class="material-icons prefix blue-text lighten-4">place</i>
                            <select name="country" required>
                                <option value="" disabled selected>Select Country</option>
                                <option value="Cameroon" >Cameroon</option>
                                <option value="Nigeria" >Nigeria</option>
                                <option value="Chad" >Chad</option>
                                <option value="Congo" >Congo</option>
                                <option value="South Africa">South Africa</option>
                                <option value="Ghana" >Ghana</option>
                                <option value="Equatorial Guinea" >Equatorial Guinea</option>
                                <option value="Senegal" >Senegal</option>
                                <option value="Kenya" >Kenya</option>
                                <option value="Uganda" >Uganda</option>
                                
                                <option value="USA" >USA</option>
                                <option value="UK" >UK</option>
                                <option value="France" >France</option>
                                <option value="China" >China</option>
                                <option value="Canada" >Canada</option>
                                <option value="Switzerland" >Switzerland</option>
                                <option value="UAE" >UAE</option>
                                <option value="South Korea" >South Korea</option>
                            </select>
                            <span class="badge alert-danger">{{ $errors->first('country') }}</span>
                            
                            <input type="checkbox" id="nletter" name="newsletter"/>
                            <label for="nletter" class="text-primary">Receive offers and newsletters</label>
                            
                            <input type="checkbox" id="terms" name="terms"/>
                            <label for="terms" class="text-primary">Agree to terms and Conditions</label><br />
                            <span class="badge alert-danger">{{ $errors->first('terms') }}</span>
                </div>
                    
                    <div class="input-field col s12">
                      
                    </div>
                    <p class="center-align">
                            <button class="waves-effect waves-light btn-flat btn-primary" type="submit" name="action">Create My Account
                                <i class="material-icons right">send</i>
                            </button>
                        </p>
                    {{Form::token()}}
                    
                {{Form::close()}}

            </div>
            <!-- /.col-md-4 -->
        </div>
        <!-- /.row -->
      
@stop