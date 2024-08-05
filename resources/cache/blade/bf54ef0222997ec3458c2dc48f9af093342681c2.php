<div id="footer">
    <div id="footer-about">
        <div class="container">
            <div class="footer-top">
                <a class="footer-logo" href="/"><img alt="Logo" src="<?php echo e(getConf('mangareader')['logo']); ?>">
                    <div class="clearfix"></div></a>
            </div>
            <div class="footer-links">
                <ul class="ulclear">
                    <li>
                        <a href="/terms" title="Terms of service"><?php echo e(L::_('Terms of service')); ?></a>
                    </li>

                    <li>
                        <a href="/contact" title="Contact"><?php echo e(L::_('Contact')); ?></a>
                    </li>

                    <li>
                        <a href="/dmca" title="DMCA">DMCA</a>
                    </li>

                    <li>
                        <a href="/sitemap.xml" title="Sitemap">Sitemap</a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="about-text">
                 <?php echo e(getConf('mangareader')['footer_text']); ?>

            </div>
            <p class="copyright">©<?php echo e(getConf('meta')['site_name']); ?> 20<?php echo e(date('y')); ?></p>
        </div>
    </div>
</div><?php /**PATH F:\PHP\HMT\resources\views/themes/mangareader/components/footer.blade.php ENDPATH**/ ?>