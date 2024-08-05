(function($) {
    var remove_iframe = setInterval(function() {
        $.each($('#disqus_thread iframe'), function(arr,x) {
            var src = $(x).attr('sandbox');
            if (src && src.match(/(allow-scripts)|(allow-popups)/gi)) {
                $(x).remove();
            }
        });
    }, 500);

    setTimeout(function() {
        clearInterval(remove_iframe);
    }, 7000);
})(jQuery);