<div class="c-breadcrumb-wrapper">
    <script type="application/ld+json">
                    {
                        "@context": "https://schema.org",
                        "@type": "BreadcrumbList",
                        "itemListElement": [{
                            "@type": "ListItem",
                            "position": 1,
                            "name": "{{ L::_("Home") }}",
                            "item": "{{ url('home') }}"
                        },{
                            "@type": "ListItem",
                            "position": 2,
                            "name": "{{ $manga->name }}",
                            "item": "{{ $manga_url }}"
                        },{
                            "@type": "ListItem",
                            "position": 3,
                            "name": "{{ $chapter->name }}"
                        }]
                    }

                    </script>
    <div class="c-breadcrumb">
        <ol class="breadcrumb">
            <li>
                <a href="{{ url('home') }}" title="{{ L::_("Read Manga Online") }}">
                    {{ L::_("Home") }}
                </a>
            </li>
            <li>
                <a href="{{ url('manga', ['m_slug'=> $manga->slug, 'm_id' => $manga->id]) }}"
                   title="{{ $manga->name }}">
                    {{ $manga->name }} </a>
            </li>
            <li>
                <a class="active" href="{{ url() }}"
                   title="{{ $manga->name }} {{ $chapter->name }}">
                    {{ $chapter->name }} </a>
            </li>
        </ol>
    </div>
</div>
