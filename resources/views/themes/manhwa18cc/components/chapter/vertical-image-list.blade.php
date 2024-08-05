@if($chapter_data->type === 'image')
    @foreach($chapter_data->content as $key => $image)
        <div class="image-placeholder">
            <img class="p{{ $key }} lazy-load" data-src="{{ $image }}"
                 src="data:image/gif;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" alt="Page {{ $key }}">
        </div>
    @endforeach

    <script>
        $.post("/ajax/manga/count-view/" + chapter_id);

        const imgLazyObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    // Chép link ảnh qua src
                    entry.target.src = entry.target.dataset?.src;
                    entry.target.classList.add('loaded');
                    // bỏ theo dõi bức ảnh này
                    observer.unobserve(entry.target);
                }
            });
        }, {
            // Chạy callback ở trên khi ảnh vừa vào view-port
            threshold: 0
        });

        document.querySelectorAll('img.lazy-load').forEach(img => {
            imgLazyObserver.observe(img)
        });
    </script>

    <style>
        .image-placeholder {
            width: fit-content;
            position: relative;
            min-height: 50px;
            background-color: rgba(252, 252, 252, 0.67);
            margin: auto;
        }


    </style>
@else
    <div class="tleft">
        {!! $chapter_data->content !!}
    </div>
    <style>

    </style>
@endif