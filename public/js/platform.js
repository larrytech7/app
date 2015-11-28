var stp_init_url = 'https://solidtrustpay.com/handle_accver.php';
var pp_init_url = 'payment';
var ew_init_url = 'dashboard/eway';
var sk_init_url = 'skrill';

$(document).ready(function(){
    $('.pmode').change(function(){
        mode = $(this).val();
        /*
        switch(mode){
            case 'pp':
                $('form.payment').attr('url',pp_init_url)
                break;
            case 'stp':
                $('form.payment').attr('url', stp_init_url)
                break;
            default:
                $('form.payment').attr('url', pp_init_url)
                break;
        } */
        if(mode == 'pp')
            $('form.payment').attr('action',pp_init_url)
        if(mode == 'stp')
            $('form.payment').attr('action', stp_init_url)
        if(mode == 'ew')       
            $('form.payment').attr('action', ew_init_url)
        if(mode == 'mm')       
            $('form.payment').attr('action', 'mobilemoney')
        if(mode == 'sk')       
            $('form.payment').attr('action', sk_init_url)
    })

})
