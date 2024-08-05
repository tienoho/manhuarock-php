@foreach($mangas as $manga)
    <div class="pin-item" data-id="{{ $manga->id }}">
        <div class="pin-title">{{ $manga->name }}</div>
    </div>
@endforeach

