<div class="sidebar-panel ">
    <div class="sidebar-title popular-sidebartt ">
        <h2 class="sidebar-pn-title"><i class="icofont-history"></i> <?php echo e(L::_("History")); ?></h2>
    </div>
    <div id="history_content" class="sidebar-pp ">
        <div id="history_loading" class="d-flex justify-content-center">
            <div class="spinner-border" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
    </div>
</div>

<script src="/manga18fx/js/history.js" type="text/javascript"></script>
<script type="text/javascript">
    $(document).ready(function () {
        getHistorys(1, 'history-sidebar', 6)
    });
</script><?php /**PATH /www/wwwroot/manhuarockz.com/resources/views/themes/manga18fx/components/history-sidebar.blade.php ENDPATH**/ ?>