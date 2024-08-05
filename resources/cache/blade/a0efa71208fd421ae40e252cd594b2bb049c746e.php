<div class="modal fade premodal" id="modaldesc" tabindex="-1" role="dialog" aria-labelledby="modalldesctitle"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalldesctitle"><?php echo e($manga->name); ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="description-modal">
                    <?php echo e($manga->description); ?>

                </div>
            </div>
        </div>
    </div>
</div><?php /**PATH D:\ANHNGHIA\HoiMeTruyen\resources\views/themes/mangareader/components/manga/modal-description.blade.php ENDPATH**/ ?>