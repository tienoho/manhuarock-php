@if(!empty($data))
    @foreach($data as $manga)
    <a href="/kusanagi-sensei-is-being-tested-10461?ref=search" class="nav-item">
        <div class="manga-poster"><img
                    src="https://img.mreadercdn.ru/_r/300x400/100/6a/75/6a752033811edcd4b60c42d482064226/6a752033811edcd4b60c42d482064226.jpg"
                    class="manga-poster-img" alt="Kusanagi-sensei is Being Tested"/></div>
        <div class="srp-detail">
            <h3 class="manga-name">Kusanagi-sensei is Being Tested</h3>
            <div class="film-infor">
                <span>Chap 271 [EN]</span> <i class="dot"></i> <span>Vol 1 [EN]</span></div>
        </div>
        <div class="clearfix"></div>
    </a>
    @endforeach

    <a href="{{ url('search', [], ['keyword' => $keyword]) }}" class="nav-item nav-bottom"> View all results<i
                class="fa fa-angle-right ml-2"></i> </a>
@else
    <a href="javascript:(0);" class="nav-item">
        <span>No results found!</span>
        <div class="clearfix"></div>
    </a>
@endif