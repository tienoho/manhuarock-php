@extends('admin.layout')

@section('css_plugins')

<link rel="stylesheet" href="//code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-bs4.min.css"
    integrity="sha512-ngQ4IGzHQ3s/Hh8kMyG4FC74wzitukRMIcTOoKT3EyzFZCILOPF0twiXOQn75eDINUfKBYmzYn2AA8DkAk8veQ=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
<style>
    div#upload-preview {
        max-height: 500px;
        overflow: auto;
    }

    .remove-preview {
        right: 16px;
        position: absolute;
        top: 5px;
        background-color: rgb(255 255 255 / 54%);
        padding: 5px 10px;
        border-radius: 6px;
        color: #dc3545;
    }

    .image-preview {
        margin-top: 20px;
    }

    .image-preview img {
        height: 200px;
        width: 100%;
        object-fit: cover;
        margin-bottom: 15px;
    }

    .input-group>.custom-file:not(:first-child) .custom-file-label,
    .input-group>.custom-file:not(:last-child) .custom-file-label {
        border-radius: 0;
    }

    .image-preview img:hover {}
</style>
@stop

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit Chương {{ $chapter->name }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('admin.manga-edit', ['m_id' => $manga->id]) }}">{{ $manga->name }}</a></li>
                        <li class="breadcrumb-item active">{{ $chapter->name }}</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content" style="min-height: 1000px;">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-edit"></i>
                    <a href="{{ url('admin.manga-edit', ['m_id' => $manga->id]) }}">{{ $manga->name }} {{ $chapter->name }}</a>
                </h3>
            </div>
            <div class="card-body">
                <form id="add-chap" action="{{ url('api.chapter-edit', ['c_id' => $chapter->id]) }}" method="POST"
                    enctype="multipart/form-data">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="chapter_index">Số tứ tự <span class="text-danger">*</span></label>
                            <input aria-invalid="true" name="chapter_index" type="text" class="form-control"
                                id="chapter_index" placeholder="VD: 1, 1.5, 2..." value="{{ $chapter->chapter_index }}">
                        </div>

                        <div class="form-group">
                            <label for="name">Tên chương <span class="text-danger">*</span></label>
                            <input aria-invalid="true" name="name" type="text" class="form-control" id="chapter_name"
                                placeholder="VD: Chapter 1, Chapter 2 ..." value="{{ $chapter->name }}">
                        </div>

                        <div class="form-group">
                            <label for="name_extend">Tên phụ</label>
                            <input name="name_extend" type="text" class="form-control" id="name_extend"
                                placeholder="VD: Hết phần 1 ..." value="{{ $chapter->name_extend }}">
                        </div>

                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" name="is_lock" id="is_lock" {{ $chapter->is_lock?'checked':'' }}>
                                <label class="custom-control-label" for="is_lock">Khóa chap</label>
                            </div>
                            <div class="f-price" style="display: {{ $chapter->is_lock?'block':'none' }}">
                                <label for="price"><i class="fas fa-dollar-sign mr-1 text-danger"></i>Giá</label>
                                <small>(mặc định 0)</small>
                                <input name="price" type="number" class="form-control" id="price" placeholder="VD: 10000" value="{{ $chapter->price }}">
                            </div>                            
                        </div>

                        <div class="form-group">
                            <div class="custom-control custom-switch d-inline-block">
                                <input {{ $chapter_content->type === 'image' ? 'checked' : '' }} type="checkbox"
                                class="custom-control-input" name="IsImageChap" id="IsImageChap">
                                <label class="custom-control-label" for="IsImageChap">Chương Ảnh</label>
                            </div>

                            <div class="ml-3 custom-control custom-switch d-inline-block">
                                <input type="checkbox" class="custom-control-input" name="isScramble" id="isScramble">
                                <label class="custom-control-label" for="isScramble">Mã Hoá Ảnh</label>
                            </div>
                        </div>

                        <div class="form-group" id="form-upload-image">
                            <label for="uploadImage">Ảnh Trong Chương</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" name="files[]" class="custom-file-input" id="inputImage"
                                        multiple>
                                    <label class="custom-file-label" for="uploadImage">Chọn file</label>
                                </div>
                            </div>

                            <div class="row" id="isUploading" style="display: none">
                                <div class="d-flex justify-content-center">
                                    <div class="spinner-border" role="status">
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                </div>
                            </div>

                            <div class="row image-preview" id="upload-preview">
                                @if(is_array($chapter_content->content))
                                @foreach($chapter_content->content as $image)
                                <div class="preview-contain col-lg-2 col-md-4 col-6" style="position:relative;">
                                    <span class="remove-preview"><i class="fas fa-trash-alt"></i></span>
                                    <img src="{{ $image }}">
                                </div>
                                @endforeach
                                @endif
                            </div>
                        </div>

                        <div class="form-group" id="form-content">
                            <input hidden="hidden" value="{{ $chapter_content->id }}" id="content-id">
                            <label for="name">Nội dung <span class="text-danger">*</span></label>
                            <textarea id="content" name="content">
                                    @if(is_array($chapter_content->content))
                                    {{ implode("\n", $chapter_content->content) }}
                                    @else
                                        {{ $chapter_content->content }}
                                    @endif
                                </textarea>
                        </div>

                        <div class="form-group">
                            <div class="custom-control custom-switch d-inline-block">
                                <input {{ $chapter->hidden === 1 ? 'checked' : '' }} type="checkbox"
                                class="custom-control-input" name="hidden" id="isHidden">
                                <label class="custom-control-label" for="isHidden">Ẩn Chương</label>
                            </div>
                        </div>

                        <input type="submit" value="Cập Nhật" name="single-chap" class="btn btnSubmit btn-success float-right">

                    </div>

                </form>

            </div>
        </div>


    </section>
</div>
@stop

@section('javascript_plugins')


<script src="https://code.jquery.com/ui/1.13.0/jquery-ui.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote.min.js"
    integrity="sha512-6rE6Bx6fCBpRXG/FWpQmvguMWDLWMQjPycXMr35Zx/HRD9nwySZswkkLksgyQcvrpYMx0FELLJVBvWFtubZhDQ=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script type="text/javascript">
    var Content = $('#content').html()

    $('#content').summernote({
        height: 200
    , })

    $(function() {

        var imagesPreview = async function(input, placeToInsertImagePreview) {
            let getURL = async function(data) {
                return new Promise(function(resolve, reject) {
                    $.ajax({
                        type: 'POST'
                        , url: '/api/upload-tmp'
                        , data: data
                        , cache: false
                        , processData: false
                        , contentType: false
                        , success: function(data) {
                            return resolve(uploadSuccess(data));
                        }
                        , error: function() {
                            return resolve(false);
                        }
                    });
                })
            }

            var uploadSuccess = function(data) {
                var Img = `<div class="preview-contain col-lg-2 col-md-4 col-6" style="position:relative;"><span class="remove-preview"><i class="fas fa-trash-alt"></i></span><img src="{URL}"/></div>`

                Img = Img.replace('{URL}', data.url)

                $(placeToInsertImagePreview).append(Img)
                loadContent();


                return true;
            }

            if (input.files) {
                var filesAmount = input.files.length;

                var keyNum = 0;
                $("#isUploading").show();



                for (i = 0; i < filesAmount; i++) {
                    var Loading = true;
                    while (Loading) {

                        var data = new FormData();
                        data.append('is_scramble', $('#isScramble').is(':checked'));
                        data.append('data', input.files[i]);

                        await getURL(data).then(function(is_uploaded) {
                            Loading = !is_uploaded
                        });

                        keyNum++;
                    }

                }

                $("#isUploading").hide();

            }

        };

        var loadChapType = function() {
            var $form_upload = $('#form-upload-image');
            if (!$('#IsImageChap').is(':checked')) {
                return $form_upload.hide();
            }
            loadContent();
            $("#upload-preview").sortable({
                opacity: 0.8,
                forceHelperSize: true
                , forcePlaceholderSize: true
                , placeholder: 'draggable-placeholder'
                , tolerance: 'pointer'
                , update: function(event, ui) {
                    loadContent()
                }
            , });
            $form_upload.show()
            $("#isUploading").hide()
            $('#inputImage').on('change', function() {
                imagesPreview(this, '#upload-preview');
            });
            $(document).on('click', '.remove-preview', function() {
                $(this).parents('.preview-contain').remove();
                loadContent();
            });
        }

        var loadContent = function() {
            $("#content").empty();

            $(".preview-contain").each(function(index) {
                console.log(index);

                var URL = $(this).find("img").attr('src')

                $("#content").append(URL + "\n");

            });

            $('#content').summernote('code', $("#content").text());
        }

        $('#IsImageChap').click(function() {
            loadChapType();
        });

        loadChapType();

        $('#add-chap #is_lock').on('change', function() {
            if ($(this).is(':checked')) {
                $('.f-price').show();
            } else {
                $('.f-price').hide();
            }
        });
        
    });

    $(function() {
        $("#add-chap").submit(function(event) {
            event.preventDefault();

            if($(".btnSubmit").prop("disabled") == true) return alert("Đang tải ảnh lên, vui lòng chờ trong giây lát!");

            $(".btnSubmit").prop("disabled", true).addClass("disabled");

            var content = $('#content').summernote('code');
            if ($('#IsImageChap').is(':checked')) {
                content = content.split("\n");
                content = $.grep(content, function(n) {
                    return n == 0 || n
                })
            }

            var hidden = 0;
            if ($("#isHidden").is(':checked')) {
                hidden = 1;
            }

            var name = $(this).find('#chapter_name').val()
                , chapter_index = $(this).find('#chapter_index').val()
                , name_extend = $(this).find('#name_extend').val();

            if (name == "") {
                alert("Chưa nhập tên chương!");
                return;
            }

            if (chapter_index == "") {
                alert("Chưa nhập tên chương!");
                return;
            }

            if (content == "") {
                alert("Không có nội dung");
                return;
            }
            var price = $('#price').val() || 0;
            var is_lock = 0;
            if ($("#is_lock").is(':checked')) {
                is_lock = 1;
            }else{
                price=0;
            }

            if(is_lock==1 && price <=0){
                alert("Giá phải lớn hơn 0");
                return;
            }

            var content_id = $('#content-id').val();
            
            var data = {
                name: name,
                chapter_index: chapter_index, 
                name_extend: name_extend,
                content: content, 
                hidden: hidden,
                content_id: content_id,
                is_lock: is_lock,
                price: price
            }

            sendData(data);
        });

        function sendData(data) {
            $.post($('#add-chap').attr('action'), data, function(response) {
                $(document).Toasts('create', {
                    title: 'Thông báo'
                    , class: 'bg-success'
                    , autohide: true
                    , delay: 1000
                    , body: response.message
                });

                $(".btnSubmit").prop("disabled", false).removeClass("disabled");
            })
        }
    })

</script>
@stop