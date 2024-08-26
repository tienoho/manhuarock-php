<div class="image-placeholder">
Chapter này đã bị khóa, vui lòng mở khóa để tiếp tục đọc
</div>
<span class="view col-sm-1" style="color: #fff;">                                        
    <button id="unlock-chapter-{{$chapter->id}}" type="button" class="btn btn-info" data-chapter-id="{{ $chapter->id }}" title="{{ $manga->name }} {{ $chapter->name }}" onclick="modalUnlockChapter('{{ $chapter->id }}','{{ $chapter->id }}')">Mở khóa chap <i class="icofont-ui-lock"></i></button>
</span>
<div id="modal-pos"></div>
<script type="text/javascript">

        function modalUnlockChapter(mangaId,chapterId){            
            if(!isLoggedIn) {
                $(document).Toasts('create', {
                                   title: 'Thông báo',
                                   class: 'bg-danger',
                                   autohide: true,
                                   delay: 1000,
                                   body: 'Bạn chưa đăng nhập'
                               })
                return;
            }

               $.get('/api/unlock-chapter-template/' + chapterId, function (data) {

                   OpenAjaxModal(data);
                   
                   $('#frmUnlockChapter').on('submit', function(e) {
                       
                        e.preventDefault(); // Ngăn chặn hành vi submit mặc định

                       // Lấy URL từ thuộc tính action của form
                       var formAction = $(this).attr('action');
                       // Lấy dữ liệu từ form
                       var formData = $(this).serialize(); // Serialize các giá trị của form
                       // Gửi dữ liệu qua AJAX
                       $.ajax({
                           url: formAction, // Sử dụng URL từ action của form
                           type: 'POST', // Phương thức gửi
                           data: formData, // Dữ liệu cần gửi
                           success: function(response) {
                               // Xử lý phản hồi từ server
                               if(response.status!=='ok'){
                                    toastr.warning(response.msg);
                               }else{
                                    toastr.success(response.msg);
                                    setTimeout(function() { 
                                        location.reload();
                                    }, 1000);                                    
                               }     
                               $('#ajax-modal').modal('hide');
                           },
                           error: function(xhr, status, error) {
                               // Xử lý nếu có lỗi xảy ra
                               console.log("ERROR : ", error);
                               toastr.warning(error);
                           }
                       });
                   });
               });
           }

           function OpenAjaxModal(html){
                let modalPos = $('#modal-pos');
                modalPos.empty();
                modalPos.html(html)
                $("#ajax-modal").modal('show');
            }

    </script>