<div class="list-search">
    @foreach($mangas as $manga)
    <div class="search-item" data-id="{{ $manga->id }}">
        <div class="search-title">{{ $manga->name }}</div>
    </div>
    @endforeach
</div>

<style>
    .list-search {
        cursor: pointer;

    }
    .search-item {
        margin: 15px 5px;
    }

    .search-item:hover {
        color: #0c84ff;
    }

    .search-title {
        font-weight: 600;
    }
</style>