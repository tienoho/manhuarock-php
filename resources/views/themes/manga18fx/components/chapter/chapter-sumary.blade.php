<div class="chapter-sumary wleft">
    <?php
    foreach (get_manga_data('genres', $manga->id, []) as $genre) {
        $genres[] = $genre->name;
    }

    ?>
    <h2>{{ L::_("Summary") }} {{ type_name($manga->type) }} {{ $manga->name }}  </h2>
    <p>You're read <a rel="nofollow" class="a-h"
                      href="{{ url('manga', ['m_id' => $manga->id, 's_slug' => $manga->slug]) }}"
                      title="{{ $manga->name }}">{{ $manga->name }}</a> manga online at <span>Manhwa18.cc</span>.
        @if(!empty($manga->other_name))
            {{ $manga->name }} {{ type_name($manga->type) }} also known
            as: {{ $manga->other_name }}.
        @endif
        This is {{ status_name($manga->status) }} {{ type_name($manga->type) }} was released
        on {{ $manga->released }}.
        @if(!empty($genres))
            {{ $manga->name }} is about {{ implode(', ', $genres) }}.
        @endif

    </p>
</div>
