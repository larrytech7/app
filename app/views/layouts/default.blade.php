<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <meta name="description" content=""/>
    <meta name="author" content=""/>

    <title>{{ $title }}</title>
    
    <link rel="icon" type="image/png" href="{{URL::to('public/images')}}/favicon.ico" />    
    <link rel="icon" type="image/gif" href="{{URL::to('public/images')}}/animated_favicon1.gif" />

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
    <!-- Bootstrap/material Core CSS -->
    <link rel="stylesheet" href="{{URL::to('public/css')}}/bootstrap.min.css" />
    <link type="text/css" href="{{URL::to('public/css')}}/bootstrap-responsive.min.css" rel="stylesheet" />

    <link type="text/css" href="{{URL::to('public/css')}}/materialize.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{URL::to('public/css')}}/jquery-ui.css" />
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css" />
    <link rel="stylesheet" href="{{URL::to('public/css')}}/font-awesome.css" />
    
    <!-- Custom CSS -->
    <link href="{{URL::to('public/css')}}/small-business.css" rel="stylesheet" />
    <link href="{{URL::to('public/css')}}/mystyle.css" rel="stylesheet" />
    <link href="{{URL::to('public/css')}}/buttons.css" rel="stylesheet" />
    <link href="{{URL::to('public/css')}}/flipper.css" rel="stylesheet"/>
    <link href="{{URL::to('public/css')}}/material-wfont.min.css" rel="stylesheet"/>

    <style>
    body {
    display: flex;
    min-height: 100vh;
    flex-direction: column;
  }

  main {
    flex: 1 0 auto;
  }
    video#bgvid { 
        position: absolute;
        top: 50%;
        left: 50%;
        min-width: 100%;
        min-height: 50%;
        width: auto;
        height: auto;
        z-index: -100;
        -webkit-transform: translateX(-50%) translateY(-50%);
        transform: translateX(-50%) translateY(-50%);
        background-size: contain; 
    }
    @media screen and (max-device-width: 800px) {
        html   {
                background: url(polina.jpg) #000 no-repeat center center fixed;
            }
    #bgvid {
            display: none;
        }
    }
    video#bgvid {
        transition: 1s opacity;
    }
    .stopfade { opacity: .5; }
   #target > ul {
    height: 200px;
    width: 80px;
    overflow-y: scroll;
    }
    .dropdown-content {max-height:200px;}
    </style>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>

    <!-- Navigation -->
    <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
        <div class=" navbar-inner">
             @if(Auth::check()==NULL)
                <a class="brand-logo" href="{{URL::route('home')}}">
                    <img src="{{URL::to('public/images')}}/logo.png" alt="HyboPay Logo" style="width: 200px;height: 150px"/>
                </a>
                @endif
                @if(Auth::check())
                <a class="brand-logo" href="{{URL::route('dashboard')}}" title="Dashboard">
                    <img src="{{URL::to('public/images')}}/logo.png" alt="HyboPay Logo" style="width: 200px;height: 150px"/>
                </a>
                @endif
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>

            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

                <div class="navbar-form navbar-right">
                    @if(Auth::check()==NULL)
                        <a class="waves-effect waves-teal btn-flat modal-trigger" href="#login" style="z-index: 10;">Login</a>
                        <a href="#signup" class="waves-effect waves-teal btn-flat blue white-text" style="z-index: 10;">Signup</a>
                    @endif
                   
                    @if(Auth::check())
                    <a href="{{URL::route('dashboard.change-password')}}" class="waves-effect waves-teal btn-flat blue" style="z-index: 10;"> <span class="glyphicon glyphicon-lock"></span>&nbsp;Change Password</a>&nbsp;&nbsp;&nbsp;
                    <a href="{{URL::route('logout')}}" class="waves-effect waves-red btn-flat black-text" style="z-index: 10;"><span class="glyphicon glyphicon-log-out"></span>&nbsp;
                    Logout </a>
                    @endif
                </div>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>

    <!-- Page Content -->
    <div class="container">
        
        @yield('content')
        <div class="divider grey"></div>
        
        <!-- Footer -->
        <footer class="page-footer grey lighten-3">
            
            <p class="pull-right"><a href="{{URL::to('privacy')}}">Privacy Policy </a>|<a href="{{URL::to('terms')}}"> Terms & Conditions </a>|<a href="{{URL::to('about')}}"> About</a></p>
            <p>&copy; {{ date('Y') }} IceTeck, Inc.</p>
      </footer>
          <!-- Login -->
      <div id="login" class="modal">
        <div class="modal-content">
          <h4>Login</h4>
         {{Form::open(array('route'=>'login', 'class'=>'form-horizontal', 'role'=>'form'))}}
          <div class="row">
                <div class="input-field col s6">
                  <i class="material-icons prefix blue-text">account_circle</i>
                  <input id="icon_prefix" type="text" name="username" class="validate" required/>
                  <label for="icon_prefix">Username</label>
                </div>
                <div class="input-field col s6">
                  <i class="material-icons prefix blue-text">lock</i>
                  <input id="icon_pass" name="password" type="password" class="validate" required />
                  <label for="icon_pass">Password</label>
                </div>
          </div>
        </div>
        <div class="modal-footer">
            <span class="left">Powered by <a href="https://iceteck.com" >Iceteck</a></span>
            <button class="waves-effect waves-light btn-flat blue-text lighten-2" type="submit" name="login">Login
                <i class="material-icons right">send</i>
            </button>
                {{Form::token()}}
            {{Form::close()}}
        </div>
      </div>
      <!-- End login -->
  
    </div>
    <!-- /.container -->

    <!-- jQuery -->
    <script type="text/javascript" src="{{URL::to('public/js')}}/jquery.js"></script>
    <script type="text/javascript" src="{{URL::to('public/js')}}/jquery-ui.js"></script>

    <!-- Bootstrap/Materialize Core JavaScript -->
    <script type="text/javascript" src="{{URL::to('public/js')}}/flipper.js"></script>
    <script type="text/javascript" src="{{URL::to('public/js')}}/md-js.js"></script>
    <script type="text/javascript" src="{{URL::to('public/js')}}/card-depth.js"></script>
    <script src="{{URL::to('public/js')}}/materialize.min.js"></script>
    <script src="{{URL::to('public/js')}}/init.js"></script>
    <script src="{{URL::to('public/js')}}/platform.js"></script>
    
    <script>
    $(document).ready(function(){
        $('.modal-trigger').leanModal();
        $('select').material_select();
        $('.loading').hide();
        $('.slider').slider({
            interval: 8000,
            height : 300
        });
        $(".dropdown-button").dropdown();
        $('.tooltiped').tooltip({delay: 50,
                                position: 'right',
                                tooltip: 'New tootlip'});
    });
    </script>
     @if(Session::has('alertMessage'))
            <div class="row">
                <script> Materialize.toast("{{Session::get('alertMessage')}}", 5000, 'green-text')</script>
            </div>
        @endif
        @if(Session::has('alertError'))
            <div class="col-lg-12 alert alert-danger alert-dismissible fade in" role="alert">
                <script> Materialize.toast("{{Session::get('alertError')}}", 5000, 'red-text')</script>
            </div>
        @endif
    <script>
      $(function() {
        $( "#tabs" ).tabs();
      });
            var vid = document.getElementById("bgvid"),
        pauseButton = document.getElementById("vidpause");
        function vidFade() {
            vid.classList.add("stopfade");
        }
    try{
        vid.addEventListener('ended', function() {
            // only functional if "loop" is removed 
             vid.pause();
        	// to capture IE10
        	vidFade();
        });

        pauseButton.addEventListener("click", function() {
            vid.classList.toggle("stopfade");
        	if (vid.paused) {
        vid.play();
        		pauseButton.innerHTML = "Pause";
        	} else {
                vid.pause();
                pauseButton.innerHTML = "Paused";
        	}
        })
        }catch(err){}
        $(function() {
          $('a[href*=#]:not([href=#])').click(function() {
            if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
              var target = $(this.hash);
              target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
              if (target.length) {
                $('html,body').animate({
                  scrollTop: target.offset().top
                }, 1000);
                return false;
              }
            }
          });
        });
        
        function ver_pass(){
            oripass = $('#password').val();
            verpass = $('#confirm_password').val();
            if(oripass == verpass)
                Materialize.toast('Passwords match', 2000, 'green-text','');
            else
                Materialize.toast('Passwords Do not match', 3000, 'red-text', '');
        }
  </script>

</body>

</html>