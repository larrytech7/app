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
            $('form.payment').attr('action', pp_init_url)
            $('.creditcard').removeClass('hide')
        }
    })
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
function convert(){
        $.ajax({
           beforeSend:  function(xhr){
                $('.cloader').addClass('active')
                $('.cloader').removeClass('hide')
           },
           url      : 'http://localhost/app/dashboard/cnv',
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
