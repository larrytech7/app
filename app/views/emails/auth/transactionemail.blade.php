
<html>
	<head>
		<title>Paygray.com | Transaction Receipt</title>
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
        <!-- Compiled and minified CSS -->
<!--
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.3/css/materialize.min.css"/>
-->     <link type="text/css" href="{{URL::to('public/css')}}/materialize.css" rel="stylesheet" />
		<style type="text/css" rel="stylesheet">
		body{
  text-align : center;
  margin:5px;
  padding :0;
  font-family: "HelveticaNeueThin";
  color: #fff;
  font-size: 20px;
  background:teal;
  
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
        <p style="text-align: center;">
            <a href="{{URL::route('home')}}" class="center" target="_blank">
	           <img class="circle" src="{{URL::to('public/images')}}/logo.png" width="250" height="180"/>
            </a>
       </p>
       <p style="text-align: center;">
            <h1 style="text-decoration: underline; text-decoration-style: wave; text-justify: auto;">Transaction Receipt</h1>
       </p>
       <hr style="text-color: black"/>
       <p>
            <span>Transaction date: {{$tdate}}</span>
            <br />
            <table>
                <th>
                    <td><h3>Participant Info</h3></td>
                </th>
                <tr>
                    <td>Receipient Email</td>
                    <td>{{$receiver_email}}</td>
                </tr>
                <tr>
                    <td>Receipient Phone </td>
                    <td> {{$receiver_number}} </td>
                </tr>
            </table>
            <table>
                <th>
                    <td><h3>Transaction Info</h3></td>
                </th>
                <tr>
                    <td>Transaction ID</td>
                    <td>{{$tid}}</td>
                </tr>
                <tr>
                    <td>STATUS </td>
                    <td style="color: red;"> {{$status}} </td>
                </tr>
                <tr>
                    <td>AMOUNT</td>
                    <td>{{$amount}}</td>
                </tr>
                <tr>
                    <td>CHARGE </td>
                    <td>{{$charge}}</td>
                </tr>
                <tr>
                    <td>TOTAL</td>
                    <td>{{$total}}</td>
                </tr>
                <tr>
                    <td>MODE</td>
                    <td>{{$mode}}</td>
                </tr>
            </table>
       </p>
       <hr />
       <p>When your transaction completes, you wll be notified. Please do well to contact us if your transaction is not confirmed under 24 hours. Our customer service is readily available to assist you</p>
       <span style="color: blueviolet;">Thanks for using our services. We hope you keep enjoying it while we keep bringing you the best experience.</span>
       
            <div class="row">
                <!-- Main content for the receipt card-->
                <div class="footer footer-div">
                    <span>&COPY;</span> {{date('Y')}} Izepay, Inc <br />
                    <a href="{{URL::to('terms')}}">Terms &AMP; Conditions</a> |
                    <a href="{{URL::to('privacy')}}">Privacy Policy</a>
                </div>
            </div>
        </div>
   
	</body>
</html>

