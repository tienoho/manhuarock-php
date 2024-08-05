<div aria-expanded="false" aria-haspopup="true" class="hrn-icon" data-toggle="dropdown">
    <i class="fas fa-bell"></i>
</div>
<div aria-labelledby="noti-list" class="dropdown-menu dropdown-menu-noti new-noti-list">
    <div class="nnl-mark">
        <a class="ma-btn notify-seen-all" data-position="header"><i class="fas fa-check mr-2"></i> Mark all as read</a>
    </div>
    @if(empty($notification))
    <div style="display: block; padding: 25px 15px; text-align: center; font-size: 14px;">
        <div class="block mb-2">
            <i class="fas fa-box-open" style="font-size: 20px;"></i>
        </div>No Notifications
    </div>
    @else
        <?php
        $total = count($notification);
        $i = 0;
        ?>
        @foreach($notification as $noti)
            <?php $i = $i + 1; ?>
            <div class="nnl-item new">
                <a target="_blank" href="{{ $noti->url }}">{{ $noti->msg }}</a>
            </div>
        @endforeach
            <a class="nnl-item nnl-more" href="#">
                <div class="text-center">View all</div>
            </a>
    @endif
</div>