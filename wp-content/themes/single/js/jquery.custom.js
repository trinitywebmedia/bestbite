/*-----------------------------------------------------------------*/
//                  Custom Script
/*-----------------------------------------------------------------*/
jQuery.noConflict();
// portfolio dimension on window resize
function zp_portfolio_item_dimension() {
    var window_width = jQuery(window).width();
    var container_width = jQuery('#container').width();

    if (window_width < 480) {
        jQuery('.element').each(function() {
            // 2 columns
            if (jQuery(this).hasClass('element-2col')) {
                item_height = jQuery(this).children('.portfolio_image').children('img').height();
                item_width = Math.floor((container_width - 20) / 1);
                jQuery(this).css({
                    "width": item_width + "px",
                    "max-width": item_width + "px"
                });
                jQuery(this).children('.portfolio_image').css({
                    "height": item_height + "px"
                });

            }

            //3 columns
            if (jQuery(this).hasClass('element-3col')) {
                item_height = jQuery(this).children('.portfolio_image').children('img').height();
                item_width = Math.floor((container_width - 20) / 1);
                jQuery(this).css({
                    "width": item_width + "px",
                    "max-width": item_width + "px"
                });
                jQuery(this).children('.portfolio_image').css({
                    "height": item_height + "px"
                });
            }

            // 4 columns
            if (jQuery(this).hasClass('element-4col')) {
                item_height = jQuery(this).children('.portfolio_image').children('img').height();
                item_width = Math.floor((container_width - 20) / 1);
                jQuery(this).css({
                    "width": item_width + "px",
                    "max-width": item_width + "px"
                });
                jQuery(this).children('.portfolio_image').css({
                    "height": item_height + "px"
                });
            }
        });
    } else if (window_width <= 600) {
        jQuery('.element').each(function() {
            // 2 columns
            if (jQuery(this).hasClass('element-2col')) {
                item_height = jQuery(this).children('.portfolio_image').children('img').height();
                item_width = Math.floor((container_width - 20) / 2);
                jQuery(this).css({
                    "width": item_width + "px"
                });
                jQuery(this).children('.portfolio_image').css({
                    "height": item_height + "px"
                });
            }

            //3 columns
            if (jQuery(this).hasClass('element-3col')) {
                item_height = jQuery(this).children('.portfolio_image').children('img').height();
                item_width = Math.floor((container_width - 20) / 2);
                jQuery(this).css({
                    "width": item_width + "px"
                });
                jQuery(this).children('.portfolio_image').css({
                    "height": item_height + "px"
                });
            }

            // 4 columns
            if (jQuery(this).hasClass('element-4col')) {
                item_height = jQuery(this).children('.portfolio_image').children('img').height();
                item_width = Math.floor((container_width - 20) / 2);
                jQuery(this).css({
                    "width": item_width + "px"
                });
                jQuery(this).children('.portfolio_image').css({
                    "height": item_height + "px"
                });
            }
        });
    } else {
        jQuery('.element').each(function() {
            // 2 columns
            if (jQuery(this).hasClass('element-2col')) {
                item_height = jQuery(this).children('.portfolio_image').children('img').height();
                item_width = Math.floor((container_width - 20) / 2);
                jQuery(this).css({
                    "width": item_width + "px"
                });
                jQuery(this).children('.portfolio_image').css({
                    "height": item_height + "px"
                });
            }

            //3 columns
            if (jQuery(this).hasClass('element-3col')) {
                item_height = jQuery(this).children('.portfolio_image').children('img').height();
                item_width = Math.floor((container_width - 30) / 3);
                jQuery(this).css({
                    "width": item_width + "px"
                });
                jQuery(this).children('.portfolio_image').css({
                    "height": item_height + "px"
                });
            }

            // 4 columns
            if (jQuery(this).hasClass('element-4col')) {
                item_height = jQuery(this).children('.portfolio_image').children('img').height();
                item_width = Math.floor((container_width - 40) / 4);
                jQuery(this).css({
                    "width": item_width + "px"
                });
                jQuery(this).children('.portfolio_image').css({
                    "height": item_height + "px"
                });
            }
        });
    }

}
jQuery(document).ready(function() {

    jQuery('#portfolio_front #container').hide();

    zp_portfolio_item_dimension();
    var jQuerycontainer = jQuery('#container');
    jQuerycontainer.isotope({
        itemSelector: '.element'
    });
    //filter
    var jQueryoptionSets = jQuery('#options .option-set'),
        jQueryoptionLinks = jQueryoptionSets.find('a');
    jQueryoptionLinks.click(function() {
        var jQuerythis = jQuery(this);
        // don't proceed if already selected
        if (jQuerythis.hasClass('selected')) {
            return false;
        }
        var jQueryoptionSet = jQuerythis.parents('.option-set');
        jQueryoptionSet.find('.selected').removeClass('selected');
        jQuerythis.addClass('selected');
        // make option object dynamically, i.e. { filter: '.my-filter-class' }
        var options = {},
            key = jQueryoptionSet.attr('data-option-key'),
            value = jQuerythis.attr('data-option-value');
        // parse 'false' as false boolean
        value = value === 'false' ? false : value;
        options[key] = value;
        if (key === 'layoutMode' && typeof changeLayoutMode === 'function') {
            // changes in layout modes need extra logic
            changeLayoutMode(jQuerythis, options)
        } else {
            // otherwise, apply new options
            jQuerycontainer.isotope(options);
        }
        return false;
    });
    jQuery('.portfolio_image').hover(function() {
        jQuery(this).children('.icon').css({
            display: 'block'
        });
    }, function() {
        jQuery(this).children('.icon').css({
            display: 'none'
        });
    });
    /*-----------------------------------------------------------------*/
    //                  Home Portfolio
    /*-----------------------------------------------------------------*/
    jQuery(".icon h4 a").click(function() {
        var theme_link = jQuery(this).attr('href').replace("\#", ".");
        var portfolio_div = jQuery(theme_link).find('.portfolio_slider');
        jQuery('.list-items').removeClass('visib');
        jQuery('.list-items').slideUp();
        jQuery(theme_link).addClass('visib');
        jQuery('#close-project').show();
        jQuery.scrollTo('#portfolio', 500);
        jQuery(theme_link).slideDown();

        if (portfolio_div) {
            jQuery('.portfolio_slider').flexslider();
        }
    });
    jQuery('#close-project a').click(function() {
        jQuery('.list-items').slideUp("medium", function() {});
        jQuery('#close-project').hide();
        jQuery('.list-items').removeClass('visib');
    });
    /*-----------------------------------------------------------------*/
    //                  Navigation Scroll
    /*-----------------------------------------------------------------*/
    jQuery('.home .nav-primary .wrap .menu-primary li a').not( '.menu-primary li.external a' ).bind('click', function(event) {
        event.preventDefault();
        var jQueryanchor = jQuery(this);
        var href = jQuery(this).attr('href');
        var n = new Array();
        var value;
        n = href.split("#");
        value = '#' + n[1];
        jQuery(' html body').stop().animate({
            scrollTop: jQuery(value).offset().top - 100
        }, 1000);
        console.log(value);
    });
    /*-------------------------------------------------*/
    //          Toggle Mobile Menu
    /*-------------------------------------------------*/
    jQuery(".menu_title").click(function() {
        jQuery(".nav-primary").slideToggle("slow");
    });
    /*-------------------------------------------------*/
    //           Tooltip
    /*-------------------------------------------------*/
    jQuery(".hastip").tipTip({
        defaultPosition: "top"
    });
    /*-------------------------------------------------*/
    //          Home Blog Meta 
    /*-------------------------------------------------*/
    jQuery('.blog_content a').hover(function() {
        jQuery(this).children('.blog_hover').css({
            display: 'block'
        });
    }, function() {
        jQuery(this).children('.blog_hover').css({
            display: 'none'
        });
    });
    /*-------------------------------------------------------------*/
    //          PrettyPhoto 
    /*------------------------------------------------------------*/
    jQuery("a[data-gal^='prettyPhoto']").prettyPhoto({
        theme: 'light_rounded',
        counter_separator_label: ' of '
    });
    /*-------------------------------------------------------------*/
    //          Updates menu items when viewing different section
    /*------------------------------------------------------------*/
    jQuery('.home .nav-primary .menu').onePageNav( {filter: ':not(.external)' });

    /*-------------------------------------------------*/
    // Toggle 
    /*-------------------------------------------------*/
    jQuery(".toggle-container").hide();
    jQuery(".trigger").toggle(function() {
        jQuery(this).addClass("active");
    }, function() {
        jQuery(this).removeClass("active");
    });
    jQuery(".trigger").click(function() {
        jQuery(this).next(".toggle-container").slideToggle();
    });
    jQuery('.trigger a').hover(function() {
        jQuery(this).stop(true, false).animate({
            color: '#666'
        }, 50);
    }, function() {
        jQuery(this).stop(true, false).animate({
            color: '#888'
        }, 150);
    });
    /*-------------------------------------------------*/
    // Accordion
    /*-------------------------------------------------*/
    jQuery('.accordion').hide();
    jQuery('.trigger-button').click(function() {
        jQuery(".trigger-button").removeClass("active")
        jQuery('.accordion').slideUp('normal');
        if (jQuery(this).next().is(':hidden') == true) {
            jQuery(this).next().slideDown('normal');
            jQuery(this).addClass("active");
        }
    });
    jQuery('.trigger-button').hover(function() {
        jQuery(this).stop(true, false).animate({
            color: '#666'
        }, 50);
    }, function() {
        jQuery(this).stop(true, false).animate({
            color: '#888'
        }, 150);
    });
    /*-----------------------------------------------------------------*/
    //                  To top Link
    /*-----------------------------------------------------------------*/
    jQuery.fn.topLink = function(settings) {
        settings = jQuery.extend({
                min: 1,
                fadeSpeed: 200
            },
            settings);
        return this.each(function() {
            var el = jQuery(this);
            el.hide();
            jQuery(window).scroll(function() {
                if (jQuery(window).scrollTop() >= settings.min) {
                    el.fadeIn(settings.fadeSpeed);
                } else {
                    el.fadeOut(settings.fadeSpeed);
                }
            });
        });
    };
    jQuery(document).ready(function() {
        jQuery('#top-link').topLink({
            min: 400,
            fadeSpeed: 500
        });
        jQuery('#top-link').click(function() {
            jQuery(' html body').stop().animate({
                scrollTop: jQuery('.site-container').offset().top
            }, 1000);
            //e.preventDefault();       
        });
    });

    // window scroll
    jQuery(window).scroll(function() {
        if (jQuery(window).scrollTop() >= 600) {
            jQuery('.site-header').css({
                "position": "fixed",
                "top": "0"
            });
            jQuery('body').addClass( 'sticky_header' );
        } else {
            jQuery('.site-header').css({
                "position": "relative",
            });
            jQuery('body').removeClass( 'sticky_header' );
        }
    });
});
/* ========== ISOTOPE FILTERING ========== */
jQuery(window).load(function() {
    jQuery('#portfolio_front #container').show();

    zp_portfolio_item_dimension();

    var jQuerycontainer = jQuery('#container');
    jQuerycontainer.isotope({
        itemSelector: '.element'
    });
});
/*-------------------------------------------------------------*/
//          Refresh isotope when window resize
/*------------------------------------------------------------*/
jQuery(window).smartresize(function() {

    zp_portfolio_item_dimension();

    var jQuerycontainer = jQuery('#container');
    jQuerycontainer.isotope({
        itemSelector: '.element'
    });
});