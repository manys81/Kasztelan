/**
 * Created by Bartek on 2016-12-11.
 */
jQuery(document).ready(function(){
    var number=jQuery("#matchNumber").data('number');

    jQuery(document).on( 'click', '.upRound', function() {
        jQuery('.downRound').show();
        number=number+1;
        if(number>=5){
            jQuery(this).hide();
            number=5;
        }
        jQuery('.ajaxChangeNumber').html(number);
        ajaxRoundMatches(number);
    })
    jQuery(document).on( 'click', '.downRound', function() {
        jQuery('.upRound').show();
        number=number-1;
        if(number<=1){
            jQuery(this).hide();
            number=1;
        }
        jQuery('.ajaxChangeNumber').html(number);
        ajaxRoundMatches(number);
    })
});
function ajaxRoundMatches(number){
    jQuery('.downRound').hide();
    jQuery('.upRound').hide();
    jQuery('#matchesLoad').html('<img class="loaderCenter" src="'+ajaxmatches.templateUrl+'/images/loader1.gif">')
    jQuery.ajax({
        url: ajaxmatches.ajaxurl,
        type: 'post',
        data: {
            action: 'my_matches_ajax',
            number: number
        },
        success: function( result ) {
            if(number<5){
                jQuery('.upRound').show();
            }
            if(number>1){
                jQuery('.downRound').show();
            }
            jQuery('#matchesLoad').html(result);
        }
    })
}