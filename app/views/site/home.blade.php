@extends('layouts.default')

@section('content')
<!-- Heading Row -->
        <div class="row">
            <video autoplay loop poster="{{URL::to('public/images')}}/logo.png" id="bgvid">
                <source src="{{$video_url}}" type="video/mp4" />
            </video>
            <button id="vidpause" class="btn-floating btn-large waves-effect waves-light blue"><i class="material-icons">pause</i></button>
        </div>
        <div class="row center" style="margin-bottom: 20%;">
            <p class="center-align"><h2 class="white-text">Make payments or send money using any provider.</h2></p>
            <p><h5 class="white-text">The best cross-wallet solution for you. Pay a mobile money user using your paypal account and more.</h5></p>
            <p></p>
            <br />
            <br />
            <a href="#signup" class="sup center-align waves-effect waves-blue btn-flat btn-large  white-text"><i class="material-icons left">person_pin</i>&nbsp;Signup freely </a>
           
            
        </div>
        <div class="clearfix"><div/><br/><br/><br/>
        <div class="row">
            <div class="col s12 m8 l8"> 
                <div class="row">
                    <div class="col s12 m4">
                      <div class="icon-block">
                        <h2 class="center green-text"><i class="material-icons large">flash_on</i></h2>
                        <h5 class="center">Speed</h5>
                        <p class="center-align">Transactions are effectuated with speed and accuracy once properly authenticated.</p>
                      </div>
                    </div>
            
                    <div class="col s12 m4">
                      <div class="icon-block">
                        <h2 class="center blue-text"><i class="material-icons large">trending_up</i></h2>
                        <h5 class="center">Efficiency</h5>
            
                        <p class="center-align">Your transactions are handled efficiently by our various giant providers and partners.</p>
                      </div>
                    </div>
            
                    <div class="col s12 m4">
                      <div class="icon-block">
                        <h2 class="center red-text lighten-5"><i class="material-icons large">dashboard</i></h2>
                        <h5 class="center">Robustness</h5>
            
                        <p class="center-align">We run on the very best web engines to provide and ensure a consistent experience.</p>
                      </div>
                    </div>
              </div>
                <div class="row">
                    <div class="col s12 m4">
                      <div class="icon-block">
                        <h2 class="center green-text"><i class="material-icons large">call_split</i></h2>
                        <h5 class="center">Opportunity & Potential</h5>
                        <p class="center-align">Pay freelancers worldwide. No need for new payment accounts. We do the heavy lifting.</p>
                      </div>
                    </div>
            
                    <div class="col s12 m4">
                      <div class="icon-block">
                        <h2 class="center blue-text"><i class="material-icons large">extension</i></h2>
                        <h5 class="center">Smart Experience</h5>
            
                        <p class="center-align">Send money to users of Paypal, Skrill, Mobile Money etc from your single account.</p>
                      </div>
                    </div>
            
                    <div class="col s12 m4">
                      <div class="icon-block">
                        <h2 class="center red-text lighten-5"><i class="material-icons large">developer_mode</i></h2>
                        <h5 class="center">Developer zone</h5>
            
                        <p class="center-align">Extend your e-commerce target market in simple steps by integrating our services.</p>
                      </div>
                    </div>
              </div>
               
                <div class="clearfix"></div>
                <!-- Public eye -->
                <div>
                    <div class="card" style="width: 500px; height: 280px;">
                        <div class="card-image">
                          <img src="{{URL::to('public/images')}}/fblack.jpg" />
                          <span class="card-title">Use more than a card.</span>
                        </div>
                        <div class="card-content">
                          <p>Leverage Paygray to make transactions accross several other payment providers.</p>
                        </div>
                      </div>
                      <div class="card" style="height: 280px;">
                        <div class="card-image">
                          <img src="{{URL::to('public/images')}}/fblack2.jpg" />
                          <span class="card-title"></span>
                        </div>
                        <div class="card-content">
                          <p>Leverage Paygray to make transactions accross several payment providers.</p>
                        </div>
                      </div>
                      <div class="card" style="width: 500px; height: 300px;">
                        <div class="card-image">
                          <img src="{{URL::to('public/images')}}/wallet1.jpg" />
                          <span class="card-title black-text">Be more flexible with Mobile.</span>
                        </div>
                        <div class="card-content">
                          <p>Use your mobile wallet and do cross-wallet transactions with ease.</p>
                        </div>
                      </div>
                      <div class="card" style="height: 300px;">
                        <div class="card-image">
                          <img src="{{URL::to('public/images')}}/mm2.jpg" />
                          <span class="card-title"></span>
                        </div>
                        <div class="card-content">
                          <p>Accept payment via mobile money providers like MTN mobile money.</p>
                        </div>
                      </div>
                </div>    
            </div>
            <!-- /.col-md-8 -->
            <div class="col s12 m4 l4" id="signup">
                <div class="well">
                <h4 id="pad">Create Account</h4>
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
                        <input id="number" name="number" type="number" min="600000000"class="validate" required/>
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
                        <input id="confirm_password" name="confirm_password" type="password" class="validate" onchange="ver_pass()" required/>
                        <label for="confirm_password">Confirm Password</label>
                         <span class="badge alert-danger">{{ $errors->first('confirm_password') }}</span>
                    </div>
                
                    <div class="input-field col s12">
                            <select name="country" id="country" required>
                                <option value="" disabled selected> Country</option>
                                <option value="Cameroon" >Cameroon</option>
                                <option value="Nigeria" >Nigeria</option>
                                <option value="South Africa">South Africa</option>
                                <option value="Ivory Coast" >Ivory Coast</option>
                                <option value="Senegal" >Senegal</option>
                                <option value="Kenya" >Kenya</option>
                                <option value="Uganda" >Uganda</option>
                                <option value="Ghana">Ghana</option> 
                                <option value="USA" >USA</option>
                                <option value="UK" >UK</option>
                                <option value="France" >France</option>
                                <!-- <option value="Germany">Germany</option> -->
                                <option value="Canada" >Canada</option>
                                <option value="South Korea" >South Korea</option>
                            </select>
                            <label for="country"><i class="material-icons blue-text lighten-4 left" style="margin-right: 15px;">place</i>Select your country</label>
                            <span class="badge alert-danger">{{ $errors->first('country') }}</span>
                    </div>
                    
                    <div class="input-field col s12">
                            <input type="checkbox" id="nletter" name="newsletter"/>
                            <label for="nletter" class="text-primary">Receive offers and newsletters</label>
                            
                            <input type="checkbox" id="terms" name="terms"/>
                            <label for="terms" class="text-primary">Agree to terms and Conditions</label><br />
                            <span class="badge alert-danger">{{ $errors->first('terms') }}</span>
                    </div>
                    <div class="input-field col s12">
                        <p class="center-align">
                            <button class="sup waves-effect waves-light btn-flat blue white-text" type="submit" name="action">Create My Account
                                <i class="material-icons right">send</i>
                            </button>
                        </p>
                    </div>
                    {{Form::token()}}
                {{Form::close()}}
                    <div class="clearfix"></div>
                </div>
              
                    <div class="client col s12">
                    						<div class="" style="max-height: 500px; overflow-y: scroll;">
                    							<ul>
                    								<li>
                    									<img src="{{URL::to('public/images')}}/derick.jpg" alt="" class="img-circle" width="100" height="100"/>
                    									<h4 class="pull-right">Alangi Derick</h4>
                    									<h6 class="pull-right">I use my mobile money to do paypal and solid trust pay transactions. Just so simple and awesome.</h6>
                    								    
                                                    </li>
                                                    <!--
                    								<li>	
                    									<img src="{{URL::to('public/images')}}/payet.jpg" alt="" class="img-circle" width="100" height="100" />
                    									<h4 class="pull-right">Annie Payet</h4>
                    									<h6>There has never been a more flexible way to pay for my online shopping. Now i can use any wallet to pay.</h6>
                    								</li>
                    								<li>
                    									<img src="{{URL::to('public/images')}}/jaolin.jpg" class="img-circle" alt="" width="100" height="100"/>
                    									<h4 class="pull-right">Jao Lin</h4>
                    									<h6>I received my freelance payment quite rapidly and conviniently without any stress</h6>
                    								</li>
                                                    -->	
                    								<div class="clearfix"> </div>
                    							</ul>
                    						</div>
                    		
                    </div>
            </div>
            <!-- /.col-md-4 -->
        </div>
        <div class="row">
            <div class="col m12">
                <h3 class="center-align">What the fans are saying about Us?</h3>
                <section class="slidr">
                <div class="flexslider">
                        <ul class="slides">
							<li>
								<img src="{{URL::to('public/images')}}/derick.jpg" alt="testimonial" class="img-circle text-center" width="130" height="130">
								<h4>Alangi Derick (Cameroon)</h4>
								<h5>I use my mobile money to do paypal and solid trust pay transactions. Couldn't be more useful.</h5>
							</li>
							<li>	
								<img src="{{URL::to('public/images')}}/payet.jpg" alt="testimonial" class="img-circle align-center" width="130" height="130">
								<h4>Annie Payet (USA)</h4>
								<h5>There has never been a more universal way to pay for my online shopping. Now i can use any wallet to pay.</h5>
							</li>
							<li>
								<img src="{{URL::to('public/images')}}/jaolin.jpg" alt="testimonial" class="img-circle" width="130" height="130"/>
								<h4>Jao Lin (China)</h4>
								<h5>I received my freelance payment quite rapidly and conviniently. It's simple and works well.</h5>
                            </li>	
                        <div class="clearfix"> </div>
                    </ul>
                </div>
                </section>
            </div>
        </div>
        <div class="row" style="background-color: black;">
            <div class="col s4">
                <div class="social">
                <h4><i class="small material-icons blue-text">verified_user</i>Certified</h4>
                    <div class="divider grey"></div>
                    <br />
                    <img src="{{URL::to('public/images')}}/visa.png" class="img img-responsive" width="110" height="110"/>
                </div>
            </div>
            <div class="col s4">
                <h4><i class="small material-icons blue-text">group_work</i> Our Partners</h4>
                <div class="divider grey"></div>
                <br />
                <a href="https://paypal.com" target="_blank">Paypal</a> | <a href="https://furthermarket.com" target="_blank">FurtherMarket</a> | <a href="http://solidtrustpay.com" target="_blank">Solid Trust Pay</a>
            </div>
            <div class="col s4" id="contact">
                <h4 ><i class="small material-icons blue-text">perm_phone_msg</i> Contact Us </h4>
                <div class="divider grey"></div> <br />
                <p class="white-text"><i class="material-icons prefix blue-text darken-3">location_on</i> &nbsp;Cameroon, Buea. FakoShip Plaza,<span> <b>Iceteck </b></span> @ &nbsp;ActivSpaces</p>
                <p class="white-text"><i class="material-icons prefix blue-text darken-3">phone</i> (+237) 678656032 | (+237) 677247206 </p>
                <p class="white-text"><i class="material-icons prefix blue-text darken-3">email</i> <a href="mailto:larryakah@gmail.com" >service@iceteck.com</a> </p>
            </div>
        </div>
        <!-- /.row -->
      
@stop