<?php

function timeago($time)
{
    $time_difference = time() - strtotime($time);

    if ($time_difference < 1) {return L::_("just now");}
    $condition = array(12 * 30 * 24 * 60 * 60 => 'year',
        30 * 24 * 60 * 60 => L::_("month"),
        24 * 60 * 60 => L::_("days"),
        60 * 60 => L::_("hours"),
        60 => L::_("minutes"),
        1 => L::_("seconds"),
    );

    foreach ($condition as $secs => $str) {
        $d = $time_difference / $secs;

        if ($d >= 1) {
            $t = round($d);
            return $t . ' ' . $str . ' ' . L::_("ago");
        }
    }
}

function get_ip_address()
{
    foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key) {
        if (array_key_exists($key, $_SERVER) === true) {
            foreach (explode(',', $_SERVER[$key]) as $ip) {
                $ip = trim($ip); // just to be safe

                if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false) {
                    return $ip;
                }
            }
        }
    }
}

if (!function_exists('str_starts_with')) {
    function str_starts_with($string, $needle): bool
    {
        return substr($string, 0, strlen($needle)) === $needle;
    }
}

function is_url($url)
{
    return filter_var($url, FILTER_VALIDATE_URL);
}

function script($url, $attributes = ['type' => 'text/javascript'])
{
    return '<script ' . attributes($attributes) . attributes(['src' => asset($url)]) . '></script>';
}

function asset($url)
{
    if (!is_url($url)) {
        $url = getenv('APP_URL') . '/' . $url . '?v=' . \Config\Config::APP_VERSION;
    }

    return $url;
}

/**
 * Convert an HTML string to entities.
 *
 * @param string $value
 *
 * @return string
 */
function entities(string $value)
{
    return htmlentities($value, ENT_QUOTES, 'UTF-8', false);
}

/**
 * Convert entities to HTML characters.
 *
 * @param string $value
 *
 * @return string
 */
function decode(string $value)
{
    return html_entity_decode($value, ENT_QUOTES, 'UTF-8');
}

/**
 * Build an HTML attribute string from an array.
 *
 * @param array $attributes
 *
 * @return string
 */
function attributes(array $attributes)
{
    $html = [];

    foreach ($attributes as $key => $value) {
        $element = attributeElement($key, $value);

        if (!is_null($element)) {
            $html[] = $element;
        }
    }

    return count($html) > 0 ? ' ' . implode(' ', $html) : '';
}

function attributeElement(string $key, $value)
{

    if (is_numeric($key)) {
        return $value;
    }

    // Treat boolean attributes as HTML properties
    if (is_bool($value) && $key !== 'value') {
        return $value ? $key : '';
    }

    if (is_array($value) && $key === 'class') {
        return 'class="' . implode(' ', $value) . '"';
    }

    if (!is_null($value)) {
        return $key . '="' . e($value, false) . '"';
    }

}

function object(): stdClass
{
    return new stdClass();
}

function googleBot($url)
{
    $header = [];
    $header[] = 'Accept: text/xml,application/xml,application/xhtml+xml,text/html;q=0.9,text/plain;q=0.8,image/png,*/*;q=0.5';
    $header[] = 'Cache-Control: max-age=0';
    $header[] = 'Content-Type: text/html; charset=utf-8';
    $header[] = 'Transfer-Encoding: chunked';
    $header[] = 'Connection: keep-alive';
    $header[] = 'Keep-Alive: 300';
    $header[] = 'Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7';
    $header[] = 'Accept-Language: en-us,en;q=0.5';
    $header[] = 'Pragma:';

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; Googlebot/2.1; +https://www.google.com/bot.html)');
    curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
    curl_setopt($curl, CURLOPT_REFERER, 'https://www.google.com');
    curl_setopt($curl, CURLOPT_ENCODING, 'gzip, deflate');
    curl_setopt($curl, CURLOPT_AUTOREFERER, true);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_TIMEOUT, 10);
    $body = curl_exec($curl);
    curl_close($curl);
    return $body;
}

function explode_by($begin, $end, $data): string
{
    $data = explode($begin, $data);
    if (isset($data[1])) {
        $data = explode($end, $data[1]);
    } else {
        $data[0] = "";
    }
    return $data[0];
}

function remove_html($text)
{
    if (is_array($text)) {
        return array_map(__FUNCTION__, $text);
    } else {
        $search = array('@<script[^>]*?>.*?</script>@si', // Chứa javascript
            '@<[\/\!]*?[^<>]*?>@si', // Chứa các thẻ HTML
            '@<style[^>]*?>.*?</style>@siU', // Chứa các thẻ style
            '@<![\s\S]*?--[ \t\n\r]*>@', // Xóa toàn bộ dữ liệu bên trong các dấu ngoặc "<" và ">"
        );
        $text = preg_replace($search, '', $text);
        $text = strip_tags($text);
        return trim($text);
    }
}

function encode_string($value)
{
    if (!$value) {
        return false;
    }

    $key = sha1('EnCRypT10nK#Y!RiSRNn');
    $strLen = strlen($value);
    $keyLen = strlen($key);
    $j = 0;
    $crypttext = '';

    for ($i = 0; $i < $strLen; $i++) {
        $ordStr = ord(substr($value, $i, 1));
        if ($j == $keyLen) {
            $j = 0;
        }
        $ordKey = ord(substr($key, $j, 1));
        $j++;
        $crypttext .= strrev(base_convert(dechex($ordStr + $ordKey), 16, 36));
    }

    return base64_encode($crypttext);
}

function decode_string($value)
{
    if (!$value) {
        return false;
    }

    $value = base64_decode($value);
    $key = sha1('EnCRypT10nK#Y!RiSRNn');
    $strLen = strlen($value);
    $keyLen = strlen($key);
    $j = 0;
    $decrypttext = '';

    for ($i = 0; $i < $strLen; $i += 2) {
        $ordStr = hexdec(base_convert(strrev(substr($value, $i, 2)), 36, 16));
        if ($j == $keyLen) {
            $j = 0;
        }
        $ordKey = ord(substr($key, $j, 1));
        $j++;
        $decrypttext .= chr($ordStr - $ordKey);
    }

    return $decrypttext;
}

function curl_image($url, $referer = 'https://www.google.com')
{

    $ch = curl_init();
    $callback = function ($ch, $str) {
        echo $str;
        ob_flush();
        flush();
        return strlen($str);
    };
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_REFERER, $referer);
    curl_setopt($ch, CURLOPT_WRITEFUNCTION, $callback);

    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_exec($ch);
    curl_close($ch);
}

function limit_text($x, $length)
{
    if (strlen($x) <= $length) {
        return $x;
    } else {
        return substr($x, 0, $length) . '...';
    }
}

function google_proxy_build($url)
{
    $data = array(
        'container' => 'focus',
        'gadget' => 'a',
        'no_expand' => 1,
        'resize_h' => 0,
        'resize_w' => 900,
        'refresh' => 60 * 60 * 24 * 12 * 365 * 5,
        'rewriteMime' => 'image/*',
        'url' => convert_url_to_proxy($url),
    );

    return 'https://images' . random_int(2, 126733) . '-focus-opensocial.googleusercontent.com/gadgets/proxy?' . http_build_query($data);
}
function convert_url_to_proxy($input)
{
    $pattern = '/^(?:https?:\/\/)?(?:[^@\/\n]+@)?(?:www\.)?([^:\/?\n]+)/im';

    return preg_replace_callback($pattern, function ($matches) {
        $domain = $matches[1];
        $url = $matches[0];
        $google_trans_domain = str_replace('.', '-', $matches[1]) . '.translate.goog';

        return (str_replace($domain, $google_trans_domain, $url));
    }, $input);
}
function gmail_proxy_build($url)
{
    $quality = input()->value('quality', 'medium');

    switch ($quality) {
        case 'high':
            $quality = 0;
            break;
        case 'medium':
            $quality = 1200;
            break;
        case 'low':
            $quality = 1000;
            break;
    }

    return getenv('APP_URL') . "/get-image?url=" . data_crypt(time() . '|' . $url) . ('&w=' . $quality);
}

function convert_url_to_proxy_wp($input)
{
    $pattern = '/^(?:https?:\/\/)?(?:[^@\/\n]+@)?(?:www\.)?([^:\/?\n]+)/im';

    return preg_replace_callback($pattern, function ($matches) {
        $domain = $matches[1];
        $url = $matches[0];
        $google_trans_domain = 'i0.wp.com/' . $domain;

        return str_replace($domain, $google_trans_domain, $url);
    }, $input);
}

function array_to_obj($array, $obj)
{
    foreach ($array as $key => $value) {
        if (is_array($value)) {
            $obj->$key = new stdClass();
            array_to_obj($value, $obj->$key);
        } else {
            $obj->$key = $value;
        }
    }
    return $obj;
}

function arrayToObject($array)
{
    $object = new stdClass();
    return array_to_obj($array, $object);
}

function string_encode($pass)
{
    $alpha = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $beta = 'nopqrstuvwxyzabcdefghijklmNOPQRSTUVWXYZABCDEFGHIJKLM';
    $abwords = strtr($pass, $alpha, $beta);

    $gamma = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $theta = 'defghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZabcd';
    $gtwords = strtr($abwords, $gamma, $theta);

    $basewords = base64_encode($gtwords);

    $equal = '==';
    $star = '*';
    $eswords = strtr($basewords, $equal, $star);

    return wordwrap($eswords, 5, "-", true);
}

// Decode String
function string_decode($pass)
{
    $negative = '-';
    $empty = '';
    $newords = strtr($pass, $negative, $empty);

    $star = '*';
    $equal = '==';
    $sewords = strtr($newords, $star, $equal);

    $basewords = base64_decode($sewords);

    $alpha = 'defghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZabcd';
    $beta = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $abwords = strtr($basewords, $alpha, $beta);

    $gamma = 'nopqrstuvwxyzabcdefghijklmNOPQRSTUVWXYZABCDEFGHIJKLM';
    $theta = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    return strtr($abwords, $gamma, $theta);
}

function get_http_status($url)
{
    // must set $url first. Duh...
    $array = @get_headers($url);

// Storing value at 1st position because
// that is only what we need to check
    $string = $array[0];

// 404 for error, 200 for no error
    if (strpos($string, "200")) {
        return 200;
    }
    return 404;
}

function img_scramble($src_binary = null, $dest_file = false, $num_segment = 3): bool
{
    if (!$src_binary) {
        return false;
    }

    $src_im = imagecreatefromstring($src_binary);

    $width = imagesx($src_im);
    $height = imagesy($src_im);

    $dest_img = imagecreatetruecolor($width, $height);

    $segment_height = ceil($height / $num_segment);

    $last_height = $height - (($num_segment - 1) * $segment_height);
    $stamp = imagecreatefrompng(ROOT_PATH . '/public/uploads/images/logo.png');
    $sx = imagesx($stamp);
    $sy = imagesy($stamp);
    $marge_right = 0;
    $marge_bottom = 5;

//    if(rand(1,2) == 1){
//        $marge_right = $width - $sx - $marge_right;
//    }

    // if(rand(1,2) == 2){
    $marge_bottom = $height - $sy - $marge_bottom;
    // }

    imagecopyresampled($src_im, $stamp, $width - $sx - $marge_right, $height - $sy - $marge_bottom, 0, 0, $sx, $sy, $sx, $sy);
    imagedestroy($stamp);

    for ($x = 1; $x <= $num_segment; $x++) {
        $xdest = 0;
        $ydest = ($x - 1) * $segment_height;
        $xsrc = 0;
        $ysrc = $height - ($x * $segment_height);
        if ($ysrc < 0) {
            $ysrc = 0;
        }

        $piece_width = $width;
        $piece_height = $x == $num_segment ? $last_height : $segment_height;
        // if($x == 1) $piece_height = $height - (($num_segment - 1)*$segment_height);
        imagecopy($dest_img, $src_im, $xdest, $ydest, $xsrc, $ysrc, $piece_width, $piece_height);
    }

    if ($dest_file) {
        imagejpeg($dest_img, $dest_file);
    } else {
        // Set the content type header - in this case image/jpeg
        header('Content-Type: image/jpeg');
        // Output the image
        imagejpeg($dest_img);
        exit();
    }

    imagedestroy($dest_img);
    imagedestroy($src_im);

    return true;
}

/**
 * @param $string
 * @param string $action e to encrypt & d to decrypt
 * @return false|string
 */
function data_crypt($string, string $action = 'e')
{
    // you may change these values to your own
    $secret_key = 'mangareader';
    $secret_iv = 'mangareader';

    $output = false;
    $encrypt_method = "AES-256-CBC";
    $key = hash('sha256', $secret_key);
    $iv = substr(hash('sha256', $secret_iv), 0, 16);

    if ($action == 'e') {
        $output = base64_encode(openssl_encrypt($string, $encrypt_method, $key, 0, $iv));
    } else if ($action == 'd') {
        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
    }

    return $output;
}

function curl_data($url, $referer = 'https://google.com')
{
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_REFERER, $referer);

    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);

    $resp = curl_exec($curl);
    curl_close($curl);

    return $resp;
}

function getConf($type)
{
    $file = ROOT_PATH . '/config/' . $type . '.php';

    if (!file_exists($file)) {
        return [];
    }

    return include $file;
}

function setConf($type, $config)
{
    $type = ROOT_PATH . '/config/' . $type . '.php';

    file_put_contents($type, '<?php return ' . var_export($config, true) . ';');
}

function isValidPHP($str)
{
    return trim(shell_exec("echo " . escapeshellarg($str) . " | php -l")) == "No syntax errors detected in -";
}

function reverse_string($str)
{
    for ($i = strlen($str) - 1, $j = 0; $j < $i; $i--, $j++) {
        $temp = $str[$i];
        $str[$i] = $str[$j];
        $str[$j] = $temp;
    }
    return $str;
}
