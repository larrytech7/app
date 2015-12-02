
<html>
	<head>
		<title>Transaction Receipt</title>
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
        <!-- Compiled and minified CSS -->
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.3/css/materialize.min.css">
		<style type="text/css" rel="stylesheet">
		body{
  text-align : center;
  margin:0;
  padding :0;
  font-family: "HelveticaNeueThin";
  color: #fff;
  font-size: 20px;
  background:#000;
  
}

.desc{
  max-width : 480px;
  margin : auto;
  width : 100%;
  margin-top : 20px;
   margin-bottom : 40px;
}
		</style>
	</head>
	<body>
        <div class="container container-fluid">
            <div class="row">
                <!-- Main content for the receipt card-->
                <div class="card-panel teal lighten-2">
                    <div class="card-title">
                        <a href="{{URL::route('home')}}" class="center" target="_blank">
							<img class="circle" src="{{URL::to('public/images')}}/logo.png" width="250" height="180"/>
                        </a>
                        <h4 class="center-align">Transaction receipt</h4>
                    </div>
                    <div class="divider grey lighten-3"></div>
                    
                        <div class="row center">
                            <div class="col s6">
                                <p><i class="material-icons black-text">today</i>Transaction Date: {{$tdate}}</p>
                                Sender <br />
								<div class="divider"></div>
                                <p><i class="material-icons black-text ">email</i>Email: {{$sender_email}}</p>
								<div class="divider"></div>
                                <p><i class="material-icons black-text ">phone</i>Number: {{$sender_number}}</p>
                            </div>
                            <div class="col s6">
								<p><i class="material-icons black-text">turned_in</i>Transaction ID: {{$tid}} </p>
                                Receiver<br />
								<div class="divider"></div>
                                <p><i class="material-icons black-text ">email</i>Email: {{$receiver_email}}</p>
                                <div class="divider"></div>
								<p><i class="material-icons black-text ">phone</i>Number: {{$receiver_number}}</p>
                            </div>
                        </div>
                        <div class="row center ">
                                <p><i class="material-icons black-text ">trending_up</i> STATUS &nbsp;&nbsp;<span> {{$status}}</span></p>
                                <p><i class="material-icons black-text ">attach_money</i> AMOUNT &nbsp;&nbsp;<span>{{$amount}}</span></p>
                                <p><i class="material-icons black-text ">attach_money</i> CHARGE &nbsp;&nbsp;<span>{{$charge}}</span></p>
                                <p><i class="material-icons black-text ">functions</i> TOTAL &nbsp;&nbsp;<span>{{$total}}</span></p>
                                <p><i class="material-icons black-text ">merge_type</i>MODE &nbsp;&nbsp;<span>{{$mode}}</span></p>                           
                        </div>
                </div>
                <div class="footer footer-div">
                    <i class="material-icons">copyright</i> {{date('Y')}} Izepay, Inc <br />
                    <a href="{{URL::to('terms')}}">Terms</a> |
                    <a href="{{URL::to('privacy')}}">Privacy Policy</a>
                </div>
            </div>
        </div>
		<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
		 <!-- Compiled and minified JavaScript -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.3/js/materialize.min.js"></script>
   
	</body>
</html>

