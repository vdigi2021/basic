jQuery(function(){
    if(jQuery( window ).width() > 800) {
        var vnex_container = "<div class='vnex_container"+(isRtl==1 ? " vnex_container_rtl":"")+"'></div>";
        var vnex_status = 0;
        jQuery("body").append(vnex_container);
        jQuery("#publish").clone().removeAttr("id").appendTo(".vnex_container");
        jQuery(window).scroll(function ()
        {
            if (jQuery(window).scrollTop() >= jQuery("#submitdiv").offset().top + jQuery("#submitdiv").height() - 21)
            {
                if (vnex_status == 0)
                {
                    vnex_status = 1;
                    jQuery(".vnex_container").fadeIn("slow");
                    jQuery(".vnex_container").css("width", (jQuery(".vnex_container input").width() + 47 < 80 ? 82 : jQuery(".vnex_container input").width() + 47) );
                }
            } else {
                if (vnex_status == 1)
                {
                    vnex_status = 0;
                    jQuery(".vnex_container").fadeOut("slow");
                }
            }
        });
    }
    jQuery(".vnex_container input").click(function() {
        jQuery(this).addClass("disabled");
        jQuery("#publish").trigger("click");
    });

});
