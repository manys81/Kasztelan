
// wow = new WOW({
  //   mobile: false
 //});
 //wow.init();
/* !animacje przy przewijaniu strony */

function slider_arrows(){
    if(jQuery('.item:last-child').hasClass('active')){
        jQuery('.right').hide();
        jQuery('.left').show();
    }
    else if(jQuery('.item:first-child').hasClass('active')){
        jQuery('.left').hide();
        jQuery('.right').show();
    }
    else{
        jQuery('.right').show();
        jQuery('.left').show();
    }
}

jQuery(document).ready(function(){
    // jQuery('#myModal').modal();
    jQuery('.carousel').carousel({
        wrap: false,
        interval: false
    });
    slider_arrows();
    jQuery('#myCarousel').on('slid.bs.carousel', function () {
        slider_arrows();
    })
    jQuery(window).resize(function(){
       jQuery('.js-show-hide').each(function(){
           if(jQuery(this).is(':visible')){
               jQuery(this).parent().find('.glyphicon').addClass('glyphicon-triangle-top').removeClass('glyphicon-triangle-bottom');
           }
           else{
               jQuery(this).parent().find('.glyphicon').addClass('glyphicon-triangle-bottom').removeClass('glyphicon-triangle-top');
           }
       });
    });
    jQuery('.js-show-hide').each(function(){
        if(jQuery(this).is(':visible')){
            jQuery(this).parent().find('.glyphicon').addClass('glyphicon-triangle-top');
        }
        else{
            jQuery(this).parent().find('.glyphicon').addClass('glyphicon-triangle-bottom');
        }
    });
    jQuery('.js-collapse').click(function(){
        jQuery(this).siblings('.js-show-hide').slideToggle('1000',"swing");
            if (jQuery(this).find('.glyphicon').hasClass('glyphicon-triangle-bottom')) {
                jQuery(this).find('.glyphicon').addClass('glyphicon-triangle-top').removeClass('glyphicon-triangle-bottom');
            }
            else {
                jQuery(this).find('.glyphicon').addClass('glyphicon-triangle-bottom').removeClass('glyphicon-triangle-top');
            }
    });

    jQuery('.filterBy').click(function(){
        var $teamcontainer= jQuery(".team-container");
        var filter=jQuery(this).data('show');
        jQuery(".filterBy:not([data-filter="+filter+"])").removeClass("active");
        jQuery(this).addClass("active");
        if (filter=='all'){
            $teamcontainer.find(".single-person").fadeIn(0);
            $teamcontainer.find(".single-person").css("opacity" , '1');
        }
        else{
            $teamcontainer.find(".single-person:not([data-filter="+filter+"])").css("opacity" , '0');
            $teamcontainer.find(".single-person:not([data-filter="+filter+"])").fadeOut(0, function(){
                $teamcontainer.find(".single-person[data-filter="+filter+"]").fadeIn(0);
                $teamcontainer.find(".single-person[data-filter="+filter+"]").css("opacity" , '1');
            });
        }

    });
    
});
