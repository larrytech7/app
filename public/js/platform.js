var stp_init_url = 'https://solidtrustpay.com/handle_accver.php';
var pp_init_url = 'payment';

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
        else if(mode == 'stp')
            $('form.payment').attr('action', stp_init_url)       
 
    })

})
