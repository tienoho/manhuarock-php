@extends('themes.mangareader.layouts.full')

@section('title', 'Hội Truyện Tranh - Điều khoản và dịch vụ')

@section('content')
    <div class="prebreadcrumb">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('home') }}">{{ L::_('Home') }}</a></li>
                    <li class="breadcrumb-item active">{{ L::_('Terms of service') }}</li>
                </ol>
            </nav>
        </div>
    </div>

    <div id="main-wrapper" class="page-layout page-infor">
        <div class="container">
            <section class="block_area block_area-infor">
                <div class="block_area-header">
                    <div class="bah-heading">
                        <h2 class="cat-heading">Các điều khoản và điều kiện</h2>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <article class="article-infor">
                    <h4 class="h4-heading">1. Điều Kiện</h4>
                    <p>Bằng cách truy cập Trang web này từ <a href="{{ url('home') }}">{{ url('home') }}</a>,
                        bạn đồng ý bị ràng buộc bởi những Điều khoản và Điều kiện Sử dụng Trang web và đồng ý rằng bạn
                        chịu trách nhiệm về thỏa thuận với
                        bất kỳ luật địa phương hiện hành nào.
                        Nếu bạn không đồng ý với bất kỳ điều khoản nào trong số này, bạn bị cấm
                        truy cập trang web này. Các tài liệu trong Trang web này có thể đã đã được bảo vệ bởi bản quyền
                        và
                        luật thương hiệu.</p>

                    <h4 class="h4-heading">2. Sửa Đổi và lỗi in, lỗi viết</h4>
                    <p>Các tài liệu xuất hiện trên Trang web của Hội Mê Truyện có thể bao gồm các lỗi kỹ thuật, đánh máy
                        hoặc nhiếp ảnh. Hội Mê Truyện sẽ không hứa rằng bất kỳ tài liệu nào trong Trang web này là chính
                        xác, đầy đủ hoặc hiện tại. Hội Mê Truyện có thể thay đổi các tài liệu có trên Trang web của mình
                        bất cứ lúc nào mà không cần thông báo. Hội Mê Truyện không đưa ra bất kỳ cam kết nào để cập nhật
                        các tài liệu.
                    </p>

                    <h4 class="h4-heading">3. Sửa đổi điều khoản sử dụng trang web</h4>
                    <p>Hội Mê Truyện có thể sửa đổi các Điều khoản sử dụng này cho Trang web của mình bất cứ lúc nào mà
                        không cần thông báo trước. Bằng cách sử dụng Trang web này, bạn đồng ý bị ràng buộc bởi phiên
                        bản hiện tại của các Điều khoản và Điều kiện sử dụng này.</p>
                    <h4 class="h4-heading">4. Quyền riêng tư của bạn</h4>
                    <p>Vui lòng đọc chính sách bảo mật của chúng tôi. .</p>
                    <h4 class="h4-heading">5. Luật quản lý</h4>
                    <p>Bất kỳ khiếu nại nào liên quan đến Trang web của Hội Mê Truyện sẽ được điều chỉnh bởi luật của BQ
                        mà không liên quan đến xung đột của các quy định pháp luật.

                    </p>
                </article>
            </section>
        </div>
    </div>
@stop
