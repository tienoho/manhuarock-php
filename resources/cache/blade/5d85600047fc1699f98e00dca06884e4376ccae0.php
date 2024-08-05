<?php
if (request()->isAjax()) {
       $manga = \Models\Model::getDB()->where('id', $manga_id)->objectBuilder()->getOne('mangas', 'rating_score, total_rating');
}

?>
<div class="block-rating">
    <div class="rating-result">
        <div class="rr-mark float-left">
            <strong><i class="fas fa-star text-warning mr-2"></i><?php echo e($manga->rating_score); ?></strong>
            <small>(<?php echo e($manga->total_rating); ?> voted)</small>
        </div>
        <div class="rr-title float-right">
            <?php echo e(L::_('Vote now')); ?>

        </div>
        <div class="clearfix"></div>
    </div>
    <div class="description">
        <?php echo e(L::_('What do you think about this manga?')); ?>

    </div>
    <div class="button-rate">
        <button class="btn btn-emo rate-bad btn-vote" data-id="<?php echo e($manga_id); ?>" data-mark="1" type="button">😩<span
                    class="ml-2"><?php echo e(L::_('Boring')); ?></span></button>
        <button class="btn btn-emo rate-normal btn-vote" data-id="<?php echo e($manga_id); ?>" data-mark="5" type="button">
            😃<span class="ml-2"><?php echo e(L::_('Great')); ?></span></button>
        <button class="btn btn-emo rate-good btn-vote" data-id="<?php echo e($manga_id); ?>" data-mark="10" type="button">
            🤩<span class="ml-2"><?php echo e(L::_('Amazing')); ?></span></button>
        <div class="clearfix"></div>
    </div>
    <div class="clearfix"></div>
</div>
<?php /**PATH D:\ANHNGHIA\HoiMeTruyen\resources\views/themes/mangareader/components/ajax/info-vote.blade.php ENDPATH**/ ?>