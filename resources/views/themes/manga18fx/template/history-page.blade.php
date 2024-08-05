<div class="history-lists row">

    @foreach($mangas as $manga)
        <div class="history-item mt-2 col-12 col-md-6">
            <div class="row">
                <div class="col-md-3 col-4">
                    <a href="{{ url('manga', ['m_slug' => $manga->slug, 'm_id' => $manga->id]) }}">
                        <div class="cover-container">
                            <img class="history-cover" alt="{{ $manga->name }}" src="{{ $manga->cover }}">
                        </div>
                    </a>

                </div>
                <div class=" col-md-9 col-8 pl-0">
                    <a href="{{ url('manga', ['m_slug' => $manga->slug, 'm_id' => $manga->id]) }}">

                        <h3 class="history-name">{{ $manga->name }}</h3>
                    </a>
                    <div class="continue"><span class="font-weight-bold text-danger">{{ L::_("Continue Reading") }}:</span> <a
                                href="{{ $current_reading[$manga->id]->url }}"> {{ $current_reading[$manga->id]->name }}</a>
                    </div>
                    <div class="list-chapter mt-2">
                        @foreach(array_slice(get_manga_data('chapters', $manga->id, []),0,2) as $chapter)
                            <div class="chapter-item">
                                                    <span class="chapter">
                                                        <a href="{{ url('chapter', ['m_slug' => $manga->slug, 'c_slug' => $chapter->slug, 'c_id' => $chapter->id ]) }}"
                                                           class="btn-link"
                                                           title="{{ $manga->name }} {{ $chapter->name }}"> {{ $chapter->name }} </a>
                                                    </span>
                                <span class="post-on">{{ time_convert($chapter->last_update) }} </span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

        </div>
    @endforeach

</div>
