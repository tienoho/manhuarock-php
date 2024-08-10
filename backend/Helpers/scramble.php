<?php

function char_at_code($str, $index)
{
    $char = mb_substr($str, $index, 1, 'UTF-8');
    if (mb_check_encoding($char, 'UTF-8')) {
        $ret = mb_convert_encoding($char, 'UTF-32BE', 'UTF-8');
        return hexdec(bin2hex($ret));
    } else {
        return null;
    }
}

function get_slice($chapter_id, $photo_id)
{
    $slice = 10;
    $a = [2, 4, 6, 8, 10, 12, 14, 16, 18, 20];
    if ($chapter_id >= 268850) {
        $md5 = md5((string)$chapter_id . $photo_id);
        $c = char_at_code($md5, strlen($md5) - 1);
        $slice = $a[($c % 10)];
    }
    return $slice;
}

function build_image($src_binary, $slice)
{
    $src_im = imagecreatefromstring($src_binary);
    $width = imagesx($src_im);
    $height = imagesy($src_im);
    $slice_height = floor($height / $slice);
//    echo $slice_height . PHP_EOL;
    $dest_img = imagecreatetruecolor($width, $height);
    if ($slice_height == 0) {
        return $image;
    }

    for ($i = 0; $i < $slice; $i++) {
        if ($i == $slice - 1) {
            $dst_x = 0;
            $dst_y = 0;
            $src_x = 0;
            $src_y = $height - $slice_height;
            $src_width = $width;
            imagecopy($dest_img, $src_im, $dst_x, $dst_y, $src_x, $src_y, $src_width, $slice_height);
        } else {
            $dst_x = 0;
            $dst_y = $i * $slice_height + $slice_height;
            // echo 'Dest Y: '.$dst_y.PHP_EOL;
            $src_x = 0;
            $src_y = $height - $slice_height * ($i + 2) - intval($height % $slice);
            // echo 'Source Y: '.$src_y.PHP_EOL;
            $src_width = $width;
            $src_height = $height;
            imagecopy($dest_img, $src_im, $dst_x, $dst_y, $src_x, $src_y, $src_width, $slice_height);
        }
    }

    ob_start();
    imagejpeg($dest_img);
    $image_data = ob_get_contents();
    ob_end_clean();

    return $image_data;
}
