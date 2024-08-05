<div class="sidebar-panel ">
    <div class="sidebar-title popular-sidebartt ">
        <h2 class="sidebar-pn-title"><i class="icofont-fire-burn"></i> {{ L::_("POPULAR MANHWA") }}</h2>
    </div>
    <div class="sidebar-pp ">
        @foreach((new Models\Manga())->trending_manga(6) as $manga)
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

    </div>
</div>