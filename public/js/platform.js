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
        alert('ok');
        event.preventDefault();
        url = $('form.payment').attr('action');
        if(url == 'transfer'){
            init_momo();
        }else{
            event.trigger();
        }
    }
function convert(){
        $.ajax({
           beforeSend:  function(xhr){
                $('.cloader').addClass('active')
                $('.cloader').removeClass('hide')
           },
           url      : 'http://izepay.dev/dashboard/cnv',
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
                        before: function(){
                                $('.notifications').show();
                                $('.notifications').html('Processing your request. Please wait')
                                },
                        type: 'POST',

                        url: 'http://localhost/app/dashboard/momo',

                        data:{
                                'from':'CashCollect',
                                'currency': $('#cur').val(),
                                'amount':$('#amount').val(),
                                'receiver'$('#number'),
                                'provider':$('#target').val(),
                                'receivercontact':$('#remail').val(),
                                'to': $('#to').val()
                            },

                        async: true,

                        dataType: "json",

                        success:function(data1){

                                   cashResult    = data1.placepayment;
                                   cashResult    = cashResult.split(',');

                                   $('.notifications').html(cashResult[1]).trigger('refresh');

                                   if(cashResult[0] == 1){
                                               checkResult = cashResult[1];
                                               checkResult = checkResult.split('=');
                                               checkPayment(checkResult[1], receiver);
                                   }
                                   else{
                                        $('#notifications').html('Error code:'+cashResult[0]+', '+cashResult[1]).trigger('refresh');
                                   }

                                   $('.notifications').append('<span class="red-text">Waiting for confirmation ... </span>');
                            },

                        error: function(e){
                            console.log('Error placepayment :'+e.responseText);
                        }

            }).always(function(){

            });
}
//check status for momo processing every 10s
function checkPayment(paymentID,receiver){

            var status = '';

            var x = setInterval(function(){

                        $.ajax({
                                   type: 'POST',

                                   url: 'http://localhost/app/dashboard/momoc',

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
                                               }
                                               else{
                                                    $('.notifications').html('Error code:'+status[0]+', '+status[1]).trigger('refresh');
                                                 //   $('.notifications').attr('src','../<?=_FMTESTDIR?>img/close2.png').trigger('refresh');
                                               }

                                               $('.notifications').html('').trigger('refresh');

                                               isOK   = false;
                                               cpt      = 0;
                                               isTreat = false;
                                   }

                        });

            },10000);// repeat check payment every 10 seconds

}