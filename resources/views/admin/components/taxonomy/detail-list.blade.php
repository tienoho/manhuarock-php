<div class="row">
    <div class="col-12 mb-3">
        <form METHOD="GET">
            <div class="input-group">
                <input type="search" PLACEHOLDER="Tìm kiếm" value="{{ input()->value('s') }}" name="s" class="form-control"/>

                <div class="input-group-append">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search"></i>
                    </button>
                </div>

            </div>
        </form>
    </div>


    @if($taxonomys)

        @foreach($taxonomys as $taxonomy)
            <div class="col-12 border-bottom pt-2 pb-2 taxonomy-item" data-id="{{ $taxonomy->id }}">
                <div class="text-bold text-info " >
                    {{ $taxonomy->name }}
                    <a data-id="{{ $taxonomy->id }}" class="ml-2 btn btn-xs btn-success edit-taxonomy">
                        <i class="fas fa-pen"></i></a>
                    <div class="btn btn-xs btn-danger delete-taxonomy">
                        <i class="fas fa-trash"></i></div>
                </div>


                <div>
                    <span class="text-bold"> Mô tả: </span> {{ $taxonomy->description }}
                </div>
            </div>


        @endforeach
    @else
        <div class="col-12">Không có dữ liệu</div>
    @endif
</div>
