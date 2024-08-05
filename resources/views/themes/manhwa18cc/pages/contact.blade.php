@extends('themes.mangareader.layouts.full')

@section('title', 'Hội Truyện Tranh - Điều khoản và dịch vụ')

@section('content')
    <div class="prebreadcrumb">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('home') }}">{{ L::_('Home') }}</a></li>
                    <li class="breadcrumb-item active">{{ L::_('Contact') }}</li>
                </ol>
            </nav>
        </div>
    </div>

    <div id="main-wrapper" class="page-layout page-contact">
        <div class="container">
            <section class="block_area block_area-contact">
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
@stop
