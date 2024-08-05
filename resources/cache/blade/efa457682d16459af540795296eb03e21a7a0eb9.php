<?php
$analytics_id = getConf('site')['analytics_id'];
?>

<?php if(!empty($analytics_id)): ?>
<script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo e($analytics_id); ?>"></script>

<script>
    window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }

        gtag('js', new Date());

        gtag('config', '<?php echo e($analytics_id); ?>');

</script>
<?php endif; ?><?php /**PATH F:\PHP\HMT\resources\views/analytics.blade.php ENDPATH**/ ?>