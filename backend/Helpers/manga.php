<?php

use Phpfastcache\Exceptions\PhpfastcacheInvalidArgumentException;
use Services\Cache;

function readingList()
{
    return [
        1 => L::_('Reading'), 2 => L::_('On-Hold'), 3 => L::_('Plan to read'), 4 => L::_('Dropped'), 5 => L::_('Completed'),
    ];
}

function sortType()
{
    return [
        'latest-updated' => L::_('Latest Updated'),
        'score' => L::_('Score'),
        'name-az' => L::_('Name A-Z'),
        'release-date' => L::_('Release Date'),
        'most-viewd' => L::_('Most Viewed'),
    ];
}

function sortName($sort_id)
{
    return sortType()[$sort_id] ?? null;
}

function getSort($sort)
{
    switch ($sort) {
        case 'latest-updated':
            $sort = 'mangas.last_update';
            break;
        case 'most-viewd':
            $sort = 'mangas.views';
            break;
        case 'name-az':
            $sort = 'mangas.name';
            break;
        case 'release-date':
            $sort = 'mangas.created_at';
            break;
        case 'score':
            $sort = 'mangas.rating_score';
            break;
        default;
            $sort = 'mangas.last_update';
    }
    return $sort;
}

function allStatus(): array
{
    return [
        "completed" => L::_('Completed'),
        "on-going" => L::_('OnGoing'),
        "on-hold" => L::_('On-Hold'),
        "canceled" => L::_('Canceled'),
    ];
}

function allComicType(): array
{
    return [
        "manga" => "Manga",
        "one-shot" => "One-shot",
        "doujinshi" => "Doujinshi",
        "light-novel" => "Light Novel",
        "manhwa" => "Manhwa",
        "manhua" => "Manhua",
    ];
}

function type_name($type_id)
{
    $types = allComicType();

    return $types[$type_id] ?? L::_("Unknown");
}

function status_name($status_id): string
{
    $status = allStatus();

    return $status[$status_id] ?? L::_("Unknown");
}

function time_convert($time)
{
    return date("d F Y", strtotime($time));
}

function base_scheme(): array
{
    return [
        "@context" => "https://schema.org",
        "@graph" => [
            [
                "@type" => "Organization",
                "@id" => url('home') . '#wrapper',
                "name" => getConf('meta')['site_name'],
                "url" => url('home'),
                "logo" => [
                    "@type" => "ImageObject",
                    "@id" => url('home') . "#logo",
                    "inLanguage" => getConf('site')['lang'],
                    "url" => asset('images/matoon.png'),
                    "width" => 215,
                    "height" => 50,
                    "caption" => getConf('meta')['home_title'],
                ],
                "image" => [
                    "@id" => url('home') . "#logo",
                ],
            ],
            [
                "@type" => "WebSite",
                "@id" => url('home') . "#website",
                "url" => url('home'),
                "name" => getConf('meta')['home_title'],
                "description" => getConf('meta')['home_description'],
                "publisher" => [
                    "@id" => url('home') . "#wrapper",
                ],
                "potentialAction" => [
                    [
                        "@type" => "SearchAction",
                        "target" => url('search') . '?keyword={search_term_string}',
                        "query-input" => "required name=search_term_string",
                    ],
                ],
                "inLanguage" => getConf('site')['lang'],
            ],
        ],
    ];
}

function home_schema()
{
    return json_encode(base_scheme());
}

function manga_schema($manga)
{
    $base_scheme = base_scheme();

    $ImageObject["@type"] = "ImageObject";
    $ImageObject["@id"] = url('manga') . "#primaryimage";
    $ImageObject["@inLanguage"] = getConf('site')['lang'];
    $ImageObject["url"] = $manga->cover;

    $base_scheme["@graph"][] = $ImageObject;

    $base_scheme["@graph"][] = [
        "@type" => "WebPage",
        "@id" => url('manga') . "#webpage",
        "url" => url('manga'),
        "name" => $manga->name,
        "description" => mb_convert_encoding(limit_text($manga->description, 150), 'UTF-8'),
        "isPartOf" => [
            "@id" => url('home') . "#ani_detail",
        ],
        "primaryImageOfPage" => [
            "@id" => url('manga') . "#primaryimage",
        ],
        "datePublished" => $manga->last_update,
        "dateModified" => $manga->last_update,
        "inLanguage" => getConf('site')['lang'],
        "potentialAction" => [
            [
                "@type" => "ReadAction",
                "target" => [
                    url('manga'),
                ],
            ],
        ],
    ];

    return json_encode($base_scheme);
}

function chaps_schema($manga, $chapters)
{
    $schema["@context"] = "http://schema.org";
    $schema["@type"] = "ItemList";

    $position = 1;
    foreach (array_slice($chapters, 0, 20) as $chap) {
        $schema["itemListElement"][] = [
            "@type" => "ListItem",
            "position" => $position,
            "url" => url("chapters", ['m_slug' => $manga->slug, 'c_slug' => $chap->slug, 'c_id' => $chap->id]),
        ];

        $position++;
    }

    return json_encode($schema);
}

function inputManga(): array
{
    $manga['name'] = input()->value('name') ?? response()->httpCode(500)->json(['message' => "Vui lòng nhập tên truyện"]);
    $manga['slug'] = input()->value('slug', null) ?? slugGenerator($manga['name']);
    $manga['other_name'] = input()->value('other_name');
    $manga['description'] = input()->value('description');
    $manga['status'] = input()->value('status');
    $manga['type'] = input()->value('type', null);
    $manga['country'] = input()->value('country', null);
    $manga['released'] = input()->value('released', null);
    $manga['hidden'] = input()->value('hidden', 0);
    if (input()->value('views')) {
        $manga['views'] = input()->value('views');
    }

    $inputHandler = request()->getInputHandler();
    $file = $inputHandler->file('cover', null);

    if (!empty($file->getTmpName()) && exif_imagetype($file->getTmpName())) {
        $filePath = sprintf("./uploads/covers/%s.jpg", $manga['slug']);
        if (file_exists($filePath)) {
            unlink($filePath);
        }

        file_put_contents($filePath, $file->getContents());

        $manga['cover'] = sprintf("%s/uploads/covers/%s.jpg?%s", getenv('APP_URL'), $manga['slug'], time());
    }

    return $manga;
}

function inputTaoxaomy(): array
{
    $taxonomys['authors'] = input()->value('authors', []);
    $taxonomys['artists'] = input()->value('artists', []);
    $taxonomys['genres'] = input()->value('genres', []);
    $taxonomys['tags'] = input()->value('tags', []);

    return $taxonomys;
}

/**
 * @param $perfix
 * @param $unique_id
 * @param $data
// * @throws PhpfastcacheInvalidArgumentException VD chapters, 12, ['cac'], ['manga', 'chapters']
 */

function set_manga_data($perfix, $unique_id, $data)
{
    Services\Manga::setMangaData($unique_id, $perfix, $data);

//    $CachedString = Cache::load()->getItem("manga.$perfix.$unique_id")->expiresAfter(60*60*24*365*2);
//    $CachedString->set($data);
//    $CachedString->addTags(["manga.$perfix.$unique_id", "$perfix.$unique_id", $perfix]);
//
//    Cache::load()->save($CachedString);
}

function get_manga_data($perfix, $unique_id, $default = null)
{
    return Services\Manga::getMangaData($unique_id, $perfix, $default);
//    $CachedString = Cache::load()->getItem("manga.$perfix.$unique_id");
//    if(!$CachedString->isHit()){
//        return $default;
//    }
//
//    return $CachedString->get();
}

function save_cover($url, $slug, $referer = 'https://google.com')
{
    $path = ROOT_PATH . "/public/uploads/covers/$slug.jpg";

    if (!file_exists($path)) {
        $data = curl_data($url, $referer);

        if (!$data) {

            return false;
        }

        file_put_contents(ROOT_PATH . "/publish/uploads/covers/$slug.jpg", $data);
    }

    return "/uploads/covers/$slug.jpg";
}

function AllSortSlug(): array
{
    return [
        'default' => 'last_update',
        'latest-updated' => 'last_update',
        'name-az' => 'name',
        'release-date' => 'created_at',
        'most-viewed' => 'views',
    ];
}

function AllSortName(): array
{
    return [
        'default' => L::_('Default'),
        'latest-updated' => L::_('Latest Updated'),
        'name-az' => L::_('Name A-Z'),
        'release-date' => L::_('Release Date'),
        'most-viewed' => L::_('Most Views'),
    ];
}

function manga_sort($sort): string
{
    return AllSortSlug()[$sort] ?? AllSortSlug()['default'];
}

function manga_name($sort)
{
    return AllSortName()[$sort] ?? AllSortName()['default'];
}

function manga_url($manga)
{
    if (!$manga) {
        return '#';
    }
    return url("manga", ['m_slug' => $manga->slug, 'm_id' => $manga->id]);
}

function chapter_url($manga, $chapter)
{
    if (!$manga || !$chapter) {
        return '#';
    }
    return url("chapter", ['m_slug' => $manga->slug, 'c_id' => $chapter->id, 'c_slug' => $chapter->slug]);
}
