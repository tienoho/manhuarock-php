@foreach($mangas as $manga)
        <div class="p-item">
            <a class="pthumb" href="{{ url('manga', ['m_slug' => $manga->slug, 'm_id' => $manga->id]) }}"
               title="{{ $manga->name }}">
                <img class="it" data-src="{{ $manga->cover }}"
                     src="{{ $manga->cover }}" alt="{{ $manga->name }}"/>
            </a>
            <div class="p-left">
                <h4>
                    <a href="{{ url('manga', ['m_slug' => $manga->slug, 'm_id' => $manga->id]) }}"
                       title="{{ $manga->name }}">
                        {{ $manga->name }} </a>
                </h4>
                <div class="mb-3" >
                    {{ L::_("Continue Reading") }} <a class="font-weight-bold text-danger" style="font-size: 14px"
                           href="{{ $current_reading[$manga->id]->url }}"> {{ $current_reading[$manga->id]->name }}</a>
                </div>


                <div class="list-chapter">
                    @if(get_manga_data('chapters', $manga->id))
                        @foreach(array_slice(get_manga_data('chapters', $manga->id),0,2) as $chapter)
                            <div class="chapter-item">
                                                <span class="chapter">
                                                    <a href="{{ url('chapter', ['m_slug' => $manga->slug, 'c_slug' => $chapter->slug, 'c_id' => $chapter->id ]) }}"
                                                       class="btn-link"
                                                       title="{{ $manga->name }} {{ $chapter->name }}"> {{ $chapter->name }} </a>
                                                </span>
                                <span class="post-on">{{ time_convert($chapter->last_update) }} </span>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    @endforeach

