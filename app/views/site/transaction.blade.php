@extends('layouts.default')

@section('content')
        <!-- Heading Row -->
        <div class="row">
            <div class="col-md-8">
                    <div class="media-body">
                              <h3 class="media-heading"><a href="{{URL::route('dashboard')}}"><i class="material-icons small blue-text">home</i></a>Transaction History</h3>
                               
                              <table class="table table-stripped table-hover" id="">
                                    <thead>
                                      <tr class="table-bordered">
                                        <th>Date</th>
                                        <th>Type</th>
                                        <th>Sender</th>
                                        <th>Status</th>
                                        <th>Amount</th>
                                        <th>Receiver</th>
                                      </tr>
                                    </thead>

                              @foreach($transactions as $transaction)
                              <tr onclick="javascript:$('div.hide').toggle();$('#{{$transaction->id}}').dialog({minWidth: 400})">
                                  <td>{{ date("F jS, Y -- g:i A",strtotime($transaction->created_at)) }}</td>
                                  <td>{{ $transaction->type }}</td>
                                  <td>{{ $transaction->sender_email }}</td>
                                  <td>{{ $transaction->status }}</td>
                                  <td>{{ $transaction->amount .' '.$transaction->currency}}</td>
                                  <td>{{ $transaction->receiver_email }}</td>
                                </tr>
                                <div id="{{$transaction->id}}" title="Transaction Details" class="modal">
                                    <p>SENT: <u>{{ date("F jS, Y -- g:i A",strtotime($transaction->created_at)) }}</u></p>
                                    <p>AMOUNT: <u>{{ $transaction->amount .' '.$transaction->currency}}</u> &nbsp; STATUS: <span class="red-text">{{ $transaction->status }}</span></p>
                                    <p>TO: <u>{{ $transaction->receiver_email }} </u></p>
                                    <p>TRANSACTION TYPE: <u>{{ $transaction->type }}</u></p>
                                    <p>TRANSACTION ID: <u>{{ $transaction->tid }}</u></p>
                                    <br />
                                    All conflicts should be indicated within 24 hours after the trasaction status has been marked completed.
                                </div>
                                @endforeach

                              </table>


                            </div>

            </div>
            <!-- /.col-md-8 -->
            <div class="col-md-4">
                <div class="flip-card active-card full-card" >
                        <div class="pcard label-info">
                            <a href=""><img class=" img-circle text-center" src="{{URL::to('public/images')}}/user.jpg"/></a>
                        </div>
                        
                        <a href="{{URL::route('viewprofile')}}" class="btn btn-primary btn-fab btn-raised " id="first" title="View User Account">
                            <span class="glyphicon glyphicon-user"></span>
                        </a>
                        <div class="well">
                            <h3>{{$user->username}}</h3>                            
                        </div>                        
                 </div>
            </div>
            <!-- /.col-md-4 -->
        </div>
        <!-- /.row -->

@stop
