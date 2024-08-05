<?php $__env->startSection('title', 'Hội Truyện Tranh - Điều khoản và dịch vụ'); ?>

<?php $__env->startSection('content'); ?>
    <div class="prebreadcrumb">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo e(url('home')); ?>"><?php echo e(L::_('Home')); ?></a></li>
                    <li class="breadcrumb-item active"><?php echo e(L::_('Contact')); ?></li>
                </ol>
            </nav>
        </div>
    </div>

    <div id="main-wrapper" class="page-layout page-contact">
        <div class="container">
            <section class="block_area block_area-contact">
                
                <div class="_8065b20b7a" data-wi="63c5278e802cb70001a5bb11">Loading...</div>
                <div class="block_area-header">
                    <div class="bah-heading">
                        <h2 class="cat-heading">Liên hệ với chúng tôi</h2>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="block_area-description">Bạn có thể liên hệ chúng tôi với bất kỳ trang mạng xã hội nào dưới đây.
                    .</div>
                <div class="contact-social-icons mt-4 mb-4">
                    <style type="text/css">
                        .contact-social-icons .btn{border: none !important; padding: 10px 25px; margin: 0 10px 10px 0} body.darkmode a.btn:hover {color: #FFFFFF;}
                    </style>
                    <a href="https://www.reddit.com/r/MangaReaderOfficial" class="btn btn-radius btn-info" style="background: #FF5700 !important">
                        <i class="fab fa-reddit mr-2"></i>Reddit</a>
                    <a href="https://twitter.com/WeMangaReader" class="btn btn-radius btn-info" style="background: #1DA1F2 !important;">
                        <i class="fab fa-twitter mr-2"></i>Twitter</a>
                    <a href="https://discord.gg/Bvc5mVcUqE" class="btn btn-radius btn-info" style="background: #7289DA !important">
                        <i class="fab fa-discord mr-2"></i>Discord</a>
                </div>
            </section>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('themes.manga18fx.layouts.full', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /www/wwwroot/2ten.net/resources/views/themes/manga18fx/pages/contact.blade.php ENDPATH**/ ?>