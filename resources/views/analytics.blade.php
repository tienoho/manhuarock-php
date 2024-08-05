@php
$analytics_id = getConf('site')['analytics_id'];
@endphp

@if(!empty($analytics_id))
<script async src="https://www.googletagmanager.com/gtag/js?id={{ $analytics_id }}"></script>

<script>
    window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }

        gtag('js', new Date());

        gtag('config', '{{ $analytics_id }}');

</script>
@endif