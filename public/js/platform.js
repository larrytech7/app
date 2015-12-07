var stp_init_url = 'https://solidtrustpay.com/handle_accver.php';
var pp_init_url = 'payment';
var ew_init_url = 'dashboard/eway';
var sk_init_url = 'skrill';

$(document).ready(function(){
    $('.pmode').change(function(){
        mode = $(this).val()
        //input validity
        if($('#number').val().length <= 0)
            Materialize.toast('Please Enter your receiver to continue', 5000, 'red-text');
        if(mode == $('.target').val())
            Materialize.toast('Use a different Payment System. Payment providers need to be different', 5000, 'red-text')
       
        if(mode == 'pp')
            $('form.payment').attr('action',pp_init_url)
        if(mode == 'stp'){
            $('form.payment').attr('action', stp_init_url)
            $('#user2').val($('.target').val())
            alert($('.target').val())
        }
        if(mode == 'ew')       
            $('form.payment').attr('action', ew_init_url)
        if(mode == 'mm')       
            $('form.payment').attr('action', 'transfer')
        if(mode == 'sk')       
            $('form.payment').attr('action', sk_init_url)
    })
    $('#number').keyup(function(){
         $('#user1').val($('#number').val())
    })
    
    $('.target').change(function(){
        if($('.pmode').val() == $(this).val())
            Materialize.toast('Use a different Payment System. Payment providers need to be different', 5000, 'red-text')
        else
            $('#user2').val($(this).val())
        
    })
})
