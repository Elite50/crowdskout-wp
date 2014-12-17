// crowdskout-wp js library

var cskt = {};

(function($) {

    cskt.accordionMenu = function() {

        function cskt_accordion(elm) {
            if (elm.hasClass('open')) {
                elm.removeClass('open');
                elm.find('li').removeClass('open');
                elm.find('ul').slideUp();
            }
            else {
                elm.addClass('open');
                elm.children('ul').slideDown();
                //element.siblings('li').children('ul').slideUp();
                //element.siblings('li').removeClass('open');
                //element.siblings('li').find('li').removeClass('open');
                //element.siblings('li').find('ul').slideUp();
            }
        };

        $('#accordionmenu li.has-sub>a>input').on('click', function() {
            $(this).parent('a').removeAttr('href').toggleClass('cskt_activate');
            var element = $(this).parent('a').parent('li');
            if ( !( element.hasClass('open') ) && $(this).parent('a').hasClass('cskt_activate') || element.hasClass('open') && !$(this).parent('a').hasClass('cskt_activate') ) { // my logic is solid!
                cskt_accordion(element);
            }
        });

        $('#accordionmenu li.has-sub>a>span').on('click', function() {
            var element = $(this).parent('a').parent('li');
            cskt_accordion(element);
        });
    };

    // make a call to the jquery-ui for sortable accordion menu elements
    $(function() {
        $( '#accordionmenu ul' ).sortable();
        $( '#accordionmenu ul' ).disableSelection();
        $( '#accordionmenu li' ).disableSelection();
    });

})(jQuery);


