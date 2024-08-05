<div class="profile-manga" style="background-image: url(/manhwa18cc/images/detail-bg.jpg);">
    <div class="centernav">
        <div class="c-breadcrumb-wrapper">
            <script type="application/ld+json">
                    {
                        "@context": "https://schema.org",
                        "@type": "BreadcrumbList",
                        "itemListElement": [
                            {
                                "@type": "ListItem",
                                "position": 1,
                                "name": "{{ url("home") }}",
                                "item": "{{ url("home") }}"
                            },
                            {
                                "@type": "ListItem",
                                "position": 2,
                                "name": "{{ $manga->name }}"
                            }
                        ]
                    }


            </script>
            <div id="zone65110184"></div>
            <div class="c-breadcrumb">
                <ol class="breadcrumb">
                    <li>
                        <a href="/" title="Read Webtoons and Korean Manhwa">
                            {{ L::_("Home") }}
                        </a>
                    </li>
                    <li>
                        <a href="{{ url() }}" title="{{ $manga->name }}" class="active">{{ $manga->name }} </a>
                    </li>
                </ol>
            </div>
        </div>
        <div class="post-title">
            <h1>
                @if($manga->adult)
                    <span>18+</span>
                @endif
                {{ $manga->name }} </h1>
        </div>

        <div class="tab-summary ">
            <div class="summary_image">
                <a href="{{ url('manga', ['m_slug' => $manga->slug, 'm_id' => $manga->id]) }}"
                   title="{{ $manga->name }}">
                    <img class="img-loading" data-src="{{ $manga->cover }}"
                         src="{{ $manga->cover }}" alt="{{ $manga->name }}"
                         title="{{ $manga->name }}">
                </a>
            </div>
            <div class="summary_content_wrap">
                <div class="summary_content">
                    <div class="post-content">
                        <div class="post-rating">
                            <div class="story-rating wleft">
                                <div class="my-rating jq-stars"></div>
                                <span class="avgrate">{{ $manga->rating_score }}</span>
                            </div>
                            <div class="is_rate" style="display: none">{{ L::_("Thanks for your vote!") }}</div>
                            <div class="post-content_item wleft">
                                <div class="summary-heading">
                                    <h5>
                                        {{ L::_("Rating") }}:
                                    </h5>
                                </div>
                                <div class="summary-content vote-details" vocab="https://schema.org/"
                                     typeof="AggregateRating">
                                    <div property="itemReviewed" typeof="Book">
                                        <span class="rate-title" property="name"
                                              title="{{ $manga->name }}">{{ $manga->name }}</span>
                                    </div>
                                    <div> Average <span property="ratingValue" id="averagerate"> {{ $manga->rating_score }}</span> / <span
                                                property="bestRating">5</span>
                                        out of <span property="ratingCount" id="countrate">{{ $manga->total_rating }}</span></div>
                                </div>
                            </div>
                        </div>
                        <div class="post-content_item wleft">
                            <div class="summary-heading">
                                <h5>
                                    {{ L::_("Alternative") }}:
                                </h5>
                            </div>
                            <div class="summary-content">
                                {{ $manga->other_name ?? L::_("Updating") }}
                            </div>
                        </div>
                        <div class="post-content_item wleft">
                            <div class="summary-heading">
                                <h5>
                                    {{ L::_("Author(s)") }}
                                </h5>
                            </div>
                            <div class="summary-content">
                                @if(!empty(($authors = get_manga_data('authors', $manga->id, []))))
                                    <div class="author-content">
                                        @foreach($authors as $author)
                                            <a href="{{ url('authors', ['authors' => $author->slug]) }}"
                                               rel="tag">{{ $author->name }}</a>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="author-content">
                                        <a href="#" rel="tag">{{ L::_("Unknown") }}</a>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="post-content_item wleft">
                            <div class="summary-heading">
                                <h5>
                                    {{ L::_("Artist(s)") }}
                                </h5>
                            </div>
                            <div class="summary-content">
                                <div class="artist-content">
                                    @if(!empty(($tartists = get_manga_data('artists', $manga->id, []))))
                                        @foreach($tartists as $tartist)
                                            <a href="{{ url('artists', ['artists' => $tartist->slug]) }}"
                                               rel="tag">{{ $tartist->name }}</a>
                                        @endforeach
                                    @else
                                        <div class="artist-content">
                                            <a href="#" rel="tag">{{ L::_("Unknown") }}</a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="post-content_item wleft">
                            <div class="summary-heading">
                                <h5>
                                    {{ L::_("Genre(s)") }}
                                </h5>
                            </div>
                            <div class="summary-content">
                                <div class="genres-content">
                                    @foreach(get_manga_data('genres', $manga->id, []) as $genre)
                                        <a href="{{ url('genres', ['genres' => $genre->slug]) }}"
                                           rel="tag">{{ $genre->name }}</a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="post-content_item wleft">
                            <div class="summary-heading">
                                <h5>
                                    {{ L::_("Type") }}
                                </h5>
                            </div>
                            <div class="summary-content">
                                <a href="{{ ($manga->type ? url('manga.type', ['type' => $manga->type]) : '#') }}">{{ type_name($manga->type) }}</a>
                            </div>
                        </div>
                    </div>
                    <div class="post-status">
                        <div class="post-content_item wleft">
                            <div class="summary-heading">
                                <h5>
                                    {{ L::_("Released") }}
                                </h5>
                            </div>
                            <div class="summary-content" style="text-align: right">
                                {{ $manga->released ?? L::_("Unknown") }}
                            </div>
                        </div>
                        <div class="post-content_item wleft">
                            <div class="summary-heading">
                                <h5>
                                    {{ L::_("Status") }}
                                </h5>
                            </div>
                            <div class="summary-content" style="text-align: right">
                                {{ status_name($manga->status) }}
                            </div>
                        </div>
                        <div class="manga-action" ng-controller="userFunction" ng-init="getstatus({{ $manga->id }})">
                            <div class="bookmark-btn wleft" ng-cloak>
                                <div ng-if="!bkresult.status" class="book-mark nbk wleft tcenter"
                                     ng-click="bookmark({{ $manga->id }})">
                                    <i class="icofont-book-mark"></i> {{ L::_("Bookmark") }}
                                </div>
                                <div ng-if="bkresult.status" class="book-mark ybk wleft tcenter"
                                     ng-click="removebookmark({{ $manga->id }})">
                                    <i class="icofont-book-mark"></i> {{ L::_("Followed") }}
                                </div>
                                <div class="sumbmrk wleft tcenter">
                                    {{ $manga->total_bookmarks }} {{ L::_("Users bookmarked") }}
                                </div>
                                <?php
                                $x = "{{bkresult.message}}";
                                ?>
                                <div class="bknotice tcenter">{{ $x }}</div>
                            </div>
                            <div class="readbtn wleft">
                                @if(!empty($chapters))
                                    <a class="rfirst tcenter" href="{{ url("chapter", [ 'm_slug' => $manga->slug, 'c_slug' => $chapters[count($chapters) - 1]->slug, 'c_id' => $chapters[count($chapters) - 1]->id]) }}">
                                        {{ L::_("Read First") }}
                                    </a>
                                    <a class="rlast tcenter" href="{{ url("chapter", [ 'm_slug' => $manga->slug, 'c_slug' => $chapters[0]->slug, 'c_id' => $chapters[0]->id]) }}">
                                        {{ L::_("Read Last") }}
                                    </a>
                                @else
                                    <a class="rfirst tcenter" href="#">
                                        {{ L::_("Read First") }}
                                    </a>
                                    <a class="rlast tcenter" href="#">
                                        {{ L::_("Read Last") }}
                                    </a>
                                @endif
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>