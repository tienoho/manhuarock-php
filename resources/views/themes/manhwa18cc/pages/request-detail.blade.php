@extends('themes.mangareader.layouts.full')

@section('title', 'Đăng Truyện Lên Website Hoimetruyen.com')

@section('content')
    <style>
        .article-infor p {
            line-height: 2.5em;
        }
    </style>
    <div class="prebreadcrumb">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('home') }}">{{ L::_('Home') }}</a></li>
                    <li class="breadcrumb-item active">{{ L::_('Đăng Truyện Lên Website Hoimetruyen.com') }}</li>
                </ol>
            </nav>
        </div>
    </div>

    <div id="main-wrapper" class="page-layout page-infor">
        <div class="container">
            <section class="block_area block_area-infor">
                <div class="block_area-header">
                    <div class="bah-heading">
                        <h2 class="cat-heading">Một Số Thông Tin Cần Lưu Ý Khi Đăng Truyện</h2>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <article class="article-infor">
                    <h4 class="h4-heading">1. Điều Kiện</h4>
                    <p>
                        + Không đăng tải bản dịch của nhóm, cá nhân khác lên để lấy phí hỗ trợ từ website.
                        <br>
                        + Không dịch chen, trùng các bộ truyện đã có trên website và chưa bị drop quá 6 tháng.
                        <br>
                        + Không buff view ảo, làm ảnh hướng tới kinh phí hỗ trợ của người khác!
                        <br>
                        <strong class="text-bold text-danger">Mọi trường hợp trên, nếu BQT phát hiện vi phạm sẽ tạm khoá quyền đăng truyện. Vui lòng liên hệ page để giải quyết!</strong>

                    </p>

                    <h4 class="h4-heading">2. Lợi ích</h4>
                    <strong class="text-info">Đối với toàn bộ thành viện hợp tác</strong>
                    <p> - Hỗ trợ lương theo từng lượt xem.<br>
                        - Giá của mỗi lượt xem sẽ thay đổi theo tháng, tuỳ vào túi tiền của admin nhé :3 (Đảm bảo không dưới 5đ/view)
                        <br>
                        - Sau khi site hoạt động ổn định, sẽ mở thêm các sự kiện leo top nhận thưởng.
                    </p>
                    <strong class="text-info">Đối với nhóm cam kết đăng độc quyền</strong>
                    <p> - Lương khi thanh toán sẽ được cộng thêm 35%
                        <br> - Hỗ trợ pr truyện
                    </p>



                    <h4 class="h4-heading">3. Yêu cầu</h4>
                    <p>
                        + Không đăng tải ảnh kém chất lượng.
                    <br>
                        + Phải đảm bảo chất lượng bản dịch, edit không đấm vào vào mắt người đọc
                    <br>
                        + Chèn <a href="https://cdn.discordapp.com/attachments/899104247780622336/930312541048041522/logo-trans.png">logo
                            <img width="120px" src="https://cdn.discordapp.com/attachments/899104247780622336/930312541048041522/logo-trans.png"></a> của website vào truyện:
                        <br>
                        như thế này:
                        <a href="https://cdn.discordapp.com/attachments/899172262870142996/930312538976026694/HOI_ME_TRUYEN.png">
                            <img width="140px" src="https://cdn.discordapp.com/attachments/899172262870142996/930312538976026694/HOI_ME_TRUYEN.png"></a>

                        <br>
                        Nhớ chèn nhé, nếu kiểm tra không thấy chèn sẽ bị giảm 50% thu nhập chương đó!
                    </p>
                    <h4 class="h4-heading">4. Vấn đề bản quyền</h4>
                    <p>BQT sẽ xoá những truyện bị báo cáo bản quyền, truyện có nội dung phỉ báng dân tộc. Vui lòng chú ý điều này!</p>
                    <h4 class="h4-heading">5. Sửa đổi điều khoản</h4>
                    <p>
                        Các điều khoản sẽ được BQT thay đổi và bổ sung sẽ được thông báo trước, nếu các bạn không đồng ý có thể ngưng hợp tác
                    </p>

                    <strong> NẾU ĐÃ ĐỒNG Ý VỚI CÁC ĐIỀU KHOẢN Ở TRÊN BẠN CÓ THỂ ĐĂNG KÝ <a class="text-bold" href="{{ url('user.request-permission') }}"> TẠI ĐÂY</a></strong>
                </article>
            </section>
        </div>
    </div>
@stop
