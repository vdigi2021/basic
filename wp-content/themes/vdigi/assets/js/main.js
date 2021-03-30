jQuery(document).ready(function ($) {

// Add lazy load

    jQuery("img").attr('loading', 'lazy');

// Stick Menu

    jQuery(window).scroll(function () {



        var scroll = jQuery(window).scrollTop();

        if (scroll >= 300) {

            jQuery(".header__menu").addClass("fixed");

            jQuery(".header__mobile").addClass("fixed");

        } else {

            jQuery(".header__menu").removeClass("fixed");

            jQuery(".header__mobile").removeClass("fixed");

        }



    });



// Back To Top

    var offset = 300,

        offset_opacity = 1200,

        scroll_top_duration = 700,

        jQueryback_to_top = jQuery('.cd-top');

    jQuery(window).scroll(function () {

        (jQuery(this).scrollTop() > offset) ? jQueryback_to_top.addClass('cd-is-visible') : jQueryback_to_top.removeClass('cd-is-visible cd-fade-out');

        if (jQuery(this).scrollTop() > offset_opacity) {

            jQueryback_to_top.addClass('cd-fade-out');

        }

    });

    //smooth scroll to top

    jQueryback_to_top.on('click', function (event) {

        event.preventDefault();

        jQuery('body,html').animate({

                scrollTop: 0,

            }, scroll_top_duration

        );

    });


// OWL SLIDE HOME
    var owl = jQuery('#owl-slide');
    owl.owlCarousel({
          loop:true,
          autoplay: true,
          navSpeed:1000,
          nav:true,
          dots: true,
          smartSpeed:2000,
          items:1,
          navText: ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>"]     
    });

      // add animate.css class(es) to the elements to be animated
      function setAnimation ( _elem, _InOut ) {
        // Store all animationend event name in a string.
        // cf animate.css documentation
        var animationEndEvent = 'webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend';

        _elem.each ( function () {
          var $elem = jQuery(this);
          var $animationType = 'animated ' + $elem.data( 'animation-' + _InOut );

          $elem.addClass($animationType).one(animationEndEvent, function () {
            $elem.removeClass($animationType); // remove animate.css Class at the end of the animations
          });
        });
      }

    // Fired before current slide change
      owl.on('change.owl.carousel', function(event) {
          var $currentItem = jQuery('.owl-item', owl).eq(event.item.index);
          var $elemsToanim = $currentItem.find("[data-animation-out]");
          setAnimation ($elemsToanim, 'out');
      });

    // Fired after current slide has been changed
      owl.on('changed.owl.carousel', function(event) {

          var $currentItem = jQuery('.owl-item', owl).eq(event.item.index);
          var $elemsToanim = $currentItem.find("[data-animation-in]");
          setAnimation ($elemsToanim, 'in');
      })
// END SLDIE OWL


// Test OWL

    jQuery("#owl-spnb").owlCarousel({

        loop: true,

        autoplay: true,

        autoplayTimeout: 4000,

        autoplayHoverPause: true,

        responsive: {

            0: {

                items: 1

            },

            600: {

                items: 2,

                nav: false

            },

            1000: {

                items: 4,

                nav: true

            }

        },

        navText: ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>"]

    });



});





