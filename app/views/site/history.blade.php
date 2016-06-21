@extends('layouts.default')

@section('content')
        <!-- Heading Row -->
        
        <div class="row">
                <div class="col s12 m3 ">
                    <div class="collection">
                        <a class="collection-item" href="{{URL::route('home')}}">
                            <i class="material-icons left ">home</i>Home
                        </a>
                        <a class="collection-item blue-text modal-trigger" href="{{URL::route('send')}}" >
                            <i class="material-icons left blue-text darken-5">payment</i>Send payment
                        </a>
                        <a class="collection-item blue-text modal-trigger" href="{{URL::route('request')}}" >
                            <i class="material-icons left blue-text darken-5">play_for_work</i>Request payment
                        </a>
                        <a href="{{URL::route('dashboard.transaction')}}" class="collection-item active blue">
                            <i class="material-icons left">assignment</i>History
                        </a>
                        <a href="#" class="opt collection-item blue-text" >
                            <i class="material-icons left blue-text lighten-1">flash_on</i>Invoices
                        </a>
                        <a href="#" class="collection-item blue-text" >
                            <i class="material-icons left blue-text lighten-1">settings</i>Settings
                        </a>
                        <a class="collection-item blue-text" href="{{URL::route('developer')}}">
                            <i class="material-icons left">business</i> Merchant
                        </a>
                        <a href="{{URL::route('apidocs')}}" class="collection-item blue-text">
                            <i class="material-icons left">library_books</i>API Docs
                        </a>
                        <a href="{{URL::route('messagecenter')}}" class="collection-item blue-text">
                            <i class="material-icons left">comment</i>Message Center
                        </a>
                    
                    </div>
                </div>
                <div class="well col s12 m9">
                    <h4>Transaction History</h4>
                    <div class="media-body">
                              <table class="table table-stripped table-hover">

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
                              {{$transactions->links()}}

                    </div>
                    
                </div>

        </div>
        <!-- /.row -->
@stop