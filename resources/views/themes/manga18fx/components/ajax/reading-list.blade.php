@if(input()->value('page') && input()->value('page') == 'read')
    <a data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn btn-sm hrr-btn @if(($type)) active @endif">
        <i class="far fa-bookmark"></i><span class="hrr-name">{{ L::_('Reading List') }}</span>
    </a>
@else
    <a aria-expanded="false" aria-haspopup="true" class="btn btn-light btn-fav @if(($type)) active @endif" data-toggle="dropdown">
        <i class="far fa-bookmark"></i>
    </a>
@endif


@if(!is_login() || !($type))
    <div aria-labelledby="ssc-list" class="dropdown-menu dropdown-menu-model">
        @foreach(readingList() as $reading_type => $reading_name)
            <a class="rl-item dropdown-item" data-manga-id="{{ $manga_id }}" data-page="{{ input()->value('page') }}"
               data-type="{{ $reading_type }}"
               href="javascript:(0);">{{ $reading_name }}</a>
        @endforeach
    </div>
@else
    <div aria-labelledby="ssc-list" class="dropdown-menu dropdown-menu-model">
        @foreach(readingList() as $reading_type => $reading_name)
            <a class="rl-item dropdown-item {{ ($reading_type == $type ? 'added' : '') }}"
               data-manga-id="{{ $manga_id }}" data-page="{{ input()->value('page') }}" data-type="{{ $reading_type }}"
               href="javascript:(0);">{{ $reading_name }} @if($reading_type == $type) <i class="fas fa-check ml-2"></i> @endif</a>
        @endforeach
            <a class="rl-item dropdown-item text-danger" href="javascript:(0);" data-manga-id="{{ $manga_id }}" data-type="0" data-page="{{ input()->value('page') }}">{{ L::_('Remove') }}</a>
    </div>
@endif
<div class="clearfix"></div>