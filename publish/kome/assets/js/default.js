
jQuery(document.documentElement).ready(function() {

    jQuery(document).on('mouseup', function(event) {
            var container = jQuery("#main-nav1");
            if (!container.is(event.target) && container.has(event.target).length === 0) {
                container.removeAttr('style')
            }
    });

    jQuery("#bar").on('click', function() {
         jQuery('#main-nav1').css("width", "264px");
    });

    jQuery("#txtSearchMB, #txtSearch").one('click', function(event) {
        event.preventDefault();

        createScript('/kome/assets/js/jquery.smartsuggest.js');
        jQuery(this).smartSuggest({
            src: "/api/manga/ajax-search"
        });
    });

});

