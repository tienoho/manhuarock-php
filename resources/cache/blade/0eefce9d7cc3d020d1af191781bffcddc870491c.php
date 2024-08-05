<script src="/manga18fx/js/comment.js" type="text/javascript"></script>
<link href="/manga18fx/css/comment.css" type="text/css" rel='stylesheet'/>

<div id="read-comment">
    <div class="comments-wrap">
        <div class="sc-header">
            <h4 class="manga-panel-title">
                <i class="icofont-comment"></i>
                <?php echo e(L::_("Comments")); ?>

            </h4>

            <div class="clearfix"></div>
        </div>
        <div id="content-comments"></div>
    </div>
</div>

<script>
    $(document).ready(function() {
        getCommentWidget();
    });
</script><?php /**PATH /www/wwwroot/2ten.net/resources/views/themes/manga18fx/components/comment.blade.php ENDPATH**/ ?>