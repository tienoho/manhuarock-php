<div class="comment-box wleft">
    <h3 class="manga-panel-title"><i
                class="icofont-speech-comments"></i> {{ L::_("MANGA DISCUSSION") }} </h3>
    <div id="comment_thread" style="width: 100%; float: left; padding: 20px 0">
        <div id="fb-root"></div>
        <div class="fb-comments"
             data-href="{{ $manga_url }}" data-width="100%" data-numposts="5"></div>

        <div id="disqus_empty">Loading...</div>
    </div>
</div>

<script>
    const fbAppId = '{{ getConf('site')['FBAppID'] }}';
    function load_commemt(type, id) {
        // Prepare the trigger and target
        var is_disqus_empty = document.getElementById('disqus_empty'),
            disqus_target = document.getElementById('comment_thread'),
            disqus_embed = document.createElement('script'),
            disqus_hook = (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]);

        // Load script asynchronously only when the trigger and target exist

        if (disqus_target && is_disqus_empty) {
            disqus_embed.type = 'text/javascript';
            disqus_embed.async = true;
            if(type === 'disqus'){
                disqus_embed.src = '//' + id + '.disqus.com/embed.js';
            } else {
                disqus_embed.src = 'https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v13.0&appId=' + id + '&autoLogAppEvents=1';
            }
            disqus_hook.appendChild(disqus_embed);
            is_disqus_empty.remove();
        }
    }

    window.addEventListener('scroll', function (e) {
        var currentScroll = document.scrollingElement.scrollTop;
        var disqus_target = document.getElementById('comment_thread');

        if (disqus_target && (currentScroll > disqus_target.getBoundingClientRect().top - 150)) {
            load_commemt('fb', fbAppId);
        }
    }, false);
</script>