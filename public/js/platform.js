var stp_init_url = 'https://solidtrustpay.com/handle_accver.php';
var pp_init_url = 'payment';
var ew_init_url = 'dashboard/eway';
var sk_init_url = 'skrill';
var cc_init_url = 'creditc';

$(document).ready(function(){
    $('ul.tabs').tabs();
    $('.pmode').change(function(){
        $('.creditcard').addClass('hide')
        mode = $(this).val()
        //input validity
        if($('#number').val().length <= 0)
            Materialize.toast('Please Enter your receiver to continue. '+mode, 5000, 'red-text');
        if(mode == $('.target').val())
            Materialize.toast('Use a different Payment System. Payment providers need to be different', 5000, 'red-text')
       
        if(mode == 'pp')
            $('form.payment').attr('action',pp_init_url)
        if(mode == 'stp'){
            $('form.payment').attr('action', stp_init_url)
        }
        if(mode == 'ew')       
            $('form.payment').attr('action', ew_init_url)
        if(mode == 'mm')       
            $('form.payment').attr('action', 'transfer')
        if(mode == 'sk')       
            $('form.payment').attr('action', sk_init_url)
        if(mode == 'cc'){
            //alert('Credit card')
            //$('form.payment').attr('action', pp_init_url)
            //$('.creditcard').removeClass('hide')
        }
    })
    //send payment button submitted
    
    //payment button functions
    $('a.stpay').click(function(){
                event.preventDefault();
                $('form.dostpay').submit();
            });
    $('a.paypal').click(function(){
                event.preventDefault();
                $('form.paypal').submit();
            });
    $('a.mobile').click(function(){
                event.preventDefault();
                $('form.mobile').submit();
            });
    $('#number').keyup(function(){
         $('#user1').val($('#number').val())
    })
    $('.target').change(function(){
        if($('.pmode').val() == $(this).val())
            Materialize.toast('Use a different Payment System. Payment providers need to be different', 5000, 'red-text')
        else
            $('#user2').val($(this).val())
        
    })
    $('a.opt').click(function(event){
        event.preventDefault();
        Materialize.toast('Not available. Coming soon', 5000, 'red-text')
    })
})
function sendpayment(event){
       // alert('ok');
        url = $('form.payment').attr('action');
        if(url == 'transfer'){
            event.preventDefault();
            num = $('#mynum').val();
            if(!isNaN(num)){
                init_momo();
                return false;
            }
            else{
                 $('.notifications').html('<span class="red-text">Error. Your phone number appears to be incomplete or not correct</span>');
                return false;
            }
        }else{
            event.trigger();
            return true;
        }
    }
function convert(){
        $.ajax({
           beforeSend:  function(xhr){
                $('.cloader').addClass('active')
                $('.cloader').removeClass('hide')
           },
           url      : 'https://izepay.iceteck.com/dashboard/cnv',
           cache    : false,
           type     : 'GET',    
           data     : {
                'from'  : $('#from').val(),
                'to'    : $('#to').val(),
                'amount': $('#amountc').val()
           },
           success  : function(result, status){
                if(status){
                    $('.result').html(result);
                }else{
                    Materialize.toast('Error: '+result+' .'+status, 5000, 'red-text', ''); 
                    console.log(result);                   
                }
                $('.cloader').removeClass('active')
                $('.cloader').addClass('hide')
           },
           error    : function(status, error){
                    Materialize.toast('Error: '+error+' .'+status, 5000, 'red-text', '');
                    console.log(JSON.stringify(error))
                    $('.cloader').removeClass('active')
                    $('.cloader').addClass('hide')
           },
               
        });
    }
var isOK        = false;
var cpt          = 0;
var isTreat = false;

function init_momo(){
            
            if(isTreat)     return;
            isTreat = true;
            var cashResult        = '';
            var checkResult      = '';
            cpt  = 0;
             
            $.ajax({
                        beforeSend: function(){
                                //alert('ok')
                                $('.notifications').removeClass('hide');
                                $('.notifications').html('<span>Processing your request. Confirm transaction on your mobile.<div class="progress"><div class="indeterminate"></div></div></span>')
                                },
                        type: 'POST',

                        url: 'https://izepay.iceteck.com/dashboard/momo',

                        data:{
                                'from':'CashCollect',
                                'currency': $('#cur').val(),
                                'amount':$('#amount').val(),
                                'receiver':$('#number').val(),
                                'provider':$('#target').val(),
                                'receivercontact':$('#remail').val(),
                                'to': $('#mynum').val()
                            },

                        dataType: "json",

                        success:function(data1){

                                 //   receiver_client = data1.to;
                                 //   receiver_sender = data1.from;
                                 //   receiver_provider = data1.provider;
                                 //   receiver_amount = data1.amount;
                                    
                                   cashResult    = data1.paymentresult; 
                                   cashResult    = cashResult.split(',');

                                   $('.notifications').html('<span class="green-text">Done. '+cashResult[1]+'</span>').trigger('refresh');
                                    console.log("response: "+data1.toString());
                                   /*
                                   if(cashResult[0] == 1){
                                               checkResult = cashResult[1];
                                               checkResult = checkResult.split('=');
                                               data = JSON.parse(data1);
                                    $('.notifications').append('<span class="red-text">Error_no '+data.error_no+' </span>');
                                    //checkPayment(checkResult[1], receiver, receiver_client, receiver_sender, receiver_provider, receiver_amount); //check
                                   }
                                   else{
                                        $('#notifications').html('Error code:'+cashResult[0]+', '+cashResult[1]).trigger('refresh');
                                   }
                                   */
                            },

                        error: function(e){
                            console.log('Error requesting payment :'+e.responseText);
                            response = JSON.parse(e.responseText);
                            $('.notifications').html('<span class="red-text">Error. '+' Transaction failed</span>');
                        }

            }).always(function(){

            });
}
//check status for momo processing every 30s
function checkPayment(paymentID,receiver, clientreceiver, clientsender, clientprovider, clientamount){

            var status = '';

            var x = setInterval(function(){

                        $.ajax({
                                   type: 'POST',

                                   url: 'https://izepay.iceteck.com/dashboard/momoc',

                                   data:{'from':'checkpayment', paymentID:paymentID, receiver:receiver},

                                   async: true,

                                   dataType: "json",

                                   success:function(data2){

                                               status = data2.checkpayment;

                                               status = status.split('|');

                                               if(status[0] == 1){
                                                    isOK = true;
                                               }
                                   },error: function(e){
                                        console.log('checkpayment error :'+e.responseText);
                                        $('.notifications').html('<span class="red-text">CheckPayment Failed</span>');
                                   }

                        }).always(function(){

                                   cpt += 1;

                                   if((cpt == 12) || isOK){                
                                    // break the timer after 2 minutes or when successful payment
                                               clearInterval(x);
                                               
                                               if(isOK){
                                                    $('#notifications').html('<span class="green-text">Transaction successful').trigger('refresh');
                                                    //push confirmation
                                                    $.ajax({
                                                        type:'POST',
                                                        url:'https://izepay.iceteck.com/dashboard/confirmmomotransaction',
                                                        async:true,
                                                        data:{
                                                            'amount':clientamount,
                                                            'sender':clientsender,
                                                            'receiver':clientreceiver,
                                                            'provider':clientprovider
                                                        },
                                                        success:function(e){cosole.log("CP success: "+e.responseText)},
                                                        error: function(e){console.log("CP Error: "+e.responseText)}
                                                        
                                                    })
                                               }
                                               else{
                                                    $('.notifications').html('<span>Error code:'+status[0]+', '+status[1]+'. Transaction interrupted. Try again </span>').trigger('refresh');
                                               }

                                               isOK   = false;
                                               cpt      = 0;
                                               isTreat = false;
                                   }
                        });

            },30000);// repeat check payment every 30 seconds

}