@extends('layouts.default')

@section('content')
<!-- Heading Row -->
        <div class="row ">
            <h1 class="center-align">About Us</h1>
            <p>We are a company making sure the African continent is not left out of the developement train. We develop financial software, enabled for the African continent.</p>
            <p>Our mission is to make remote payments easier than never before giving equal opportunity to every one in the world.</p>
            <p>
                Sending money to and from Africa has never been easier until Izepay arrived. We built this product so that Africa can trade better and faster with the rest of the world.
                We have harnessed the latest technologies to develop top level simple products for the benefit of the African Continent.
            </p>
        </div>
        <!-- Team profile -->
        <div class="row">
            <div class="col s4">
                <img class="circle" width="150" height="160" src="{{URL::to('public/images')}}/ceo.jpg"/>
                <a href="http://google.com/+LarryAkah" target="_blank"><h5 class="teal-text lighten-1">Larry Akah H N</h5></a>
                Founder, CEO
            </div>
            <div class="col s4">
                <img class="circle" width="150" height="160" src="{{URL::to('public/images')}}/cto.JPG"/>
                <a href="https://plus.google.com/116058943353822698948" target="_blank"><h5 class="teal-text lighten-1">Rocard Fonkeng</h5></a>
                CTO
            </div>
            <div class="col s4">
                <img class="circle" width="150" height="160" src="{{URL::to('public/images')}}/gravatar.jpg"/>
                <h5 class="teal-text lighten-1">Amandine Nguietchan S</h5>
                Accounting and Marketting
            </div>
        </div>
        <div class="row">
                    <div class="col s12 center" id="contact">
                      <i class="large material-icons blue-text">perm_phone_msg</i>
                      <h4>Contact Us</h4>
                      <p><i class="material-icons prefix blue-text darken-3">location_on</i> &nbsp;Cameroon, Buea. FakoShip Plaza,<span> <b>Iceteck </b>Inc.</span> @ &nbsp;ActivSpaces</p>
                      <p><i class="material-icons prefix blue-text darken-3">phone</i> (+237) 678656032 | (+237) 677247206 </p>
                      <p><i class="material-icons prefix blue-text darken-3">email</i> <a href="mailto:larryakah@gmail.com" >service@iceteck.com</a> </p>
                    </div>
            </div>
            
        <!-- /.row -->
@stop