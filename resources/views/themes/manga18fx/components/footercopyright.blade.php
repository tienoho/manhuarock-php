<div class="footercopyright wleft tleft">
    <div class="centernav">
        <div class="footer-az">
            <div class="copyright">
                <div class="txt wleft" style="text-align: left;">
                    <div class="row">
                        <div class="col-12 col-md-6 tleft">
                            <img style="max-width: 200px; width: 100%;" class="mr-2 mb-2" src="/manhwa18cc/images/images-manhwa18.png?v4">
                            <p class="mb-3">Tất cả các nội dung trên website đều là sưu tầm trên internet hoặc do các thành viên đóng góp. Nếu có bất kỳ khiếu nại nào liên quan đến vấn đề quản quyền tác giả hãy liên lạc cho chúng tôi, chúng tôi sẽ gỡ nó xuống sớm nhất có thể. Cảm ơn.</p>

                            <p class="mb-3">
                                Truyện trên trang có nội dung hư cấu, chỉ có tính chất minh họa, giải trí. Không nên áp dụng, tuyên truyền văn hóa vào thực tế!!
                            </p>


                        </div>
                        <div class="col-12 col-md-6">
                            <div class="tag-footer mb-3">
                                @foreach(explode('|', $siteConf['tag_footer']) as $tag)

                                    <a href="#" title="{{ $tag }}">{{ $tag }}</a>

                                @endforeach
                            </div>


                            <p>Copyright © 20{{ date('y') }} {{ getConf('meta')['site_name'] }} - All rights reserved.</p>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
