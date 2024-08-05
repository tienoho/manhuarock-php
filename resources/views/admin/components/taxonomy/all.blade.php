@foreach($taxonomys as $taxonomy)
    <a class="btn btn-info" href="{{ url(null, ['type' => $taxonomy->taxonomy]) }}">{{ ucfirst($taxonomy->taxonomy) }}</a>
@endforeach