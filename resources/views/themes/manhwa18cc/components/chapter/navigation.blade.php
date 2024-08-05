<div class="chap-navigation wleft tcenter">
    <select aria-label="select-chap" class="navi-change-chapter">
        @foreach($chapters as $chapter_item)
            <option {{ $chapter->id === $chapter_item->id ? 'selected' : '' }}
                    data-c="{{ url('chapter', ["m_slug" => $manga->slug, "c_slug" => $chapter_item->slug, "c_id"=> $chapter_item->id]) }}">
                {{ $chapter_item->name }}@if($chapter_item->name_extend): {{ $chapter_item->name_extend }}@endif
            </option>
        @endforeach
    </select>
    <div class="navi-change-chapter-btn">
        <a class="navi-change-chapter-btn-prev a-h" href="#"><i
                    class="icofont-swoosh-left"></i> {{ L::_("PREV CHAPTER") }}</a>
        <a class="navi-change-chapter-btn-next a-h" href="#">{{ L::_("NEXT CHAPTER") }} <i
                    class="icofont-swoosh-right"></i></a>
    </div>
</div>