<?php

/**
 * @author Martin Okorodudu <webmaster@fotocrib.com>
 *  This script contains functions for scrambling image files
 */

require_once __DIR__ . '/Utils.php';

/*
 * break up $img into cells of width $cell_w and height $cell_h
 */
function decompose($img, $cell_w, $cell_h)
{
    if (!is_numeric($cell_w) || !is_numeric($cell_h)) {
        die("Error: non numeric input to decompose function");
    }
    $w = imagesx($img);
    $h = imagesy($img);

    if ($cell_w > $w || $cell_h > $h) {
        die("Error: cell image dimensions may not exceed image dimensions");
    }

    $new_img_w = $w;
    $new_img_h = $h;

    //resize image to fit cells exactly
    if ($w % $cell_w != 0) {
        $new_img_w = $cell_w - ($w % $cell_w) + $w;
    }
    if ($h % $cell_h != 0) {
        $new_img_h = $cell_h - ($h % $cell_h) + $h;
    }

    $img = resize($img, $new_img_w, $new_img_h);

    //grab new dimensions
    $w = imagesx($img);
    $h = imagesy($img);

    $cell_img_array = array();
    for ($j = 0; $j < $h; $j = $j + $cell_h) {

        //stores row cells
        $row_array = array();

        for ($i = 0; $i < $w; $i = $i + $cell_w) {

            //copy out cell
            $cell_img = imagecreatetruecolor($cell_w, $cell_h);
            imagecopy($cell_img, $img, 0, 0, $i, $j, $cell_w, $cell_h);

            $row_array[] = $cell_img;
        }
        //add row array to result
        $cell_img_array[] = $row_array;
    }
    return $cell_img_array;
}

/*
 * reconstructs a full image from $cell_img_array
 * $cell_img_array is a 2D array of image resources
 */
function reconstruct($cell_img_array)
{

    if (!empty($cell_img_array)) {
        //get cell image dimensions
        $cell_img = $cell_img_array[0][0];

        $cell_w = 0;
        $cell_h = 0;

        $cell_w = imagesx($cell_img);
        $cell_h = imagesy($cell_img);

        //get reconstructed image dimensions
        $row_len = count($cell_img_array);
        $col_len = count($cell_img_array[0]);

        $w = $col_len * $cell_w;
        $h = $row_len * $cell_h;

        if ($cell_w > $w || $cell_h > $h) {
            die("Error: cell image dimensions may not exceed image dimensions");
        }

        $img = imagecreatetruecolor($w, $h);

        for ($j = 0; $j < $row_len; $j++) {
            for ($i = 0; $i < $col_len; $i++) {
                $cell_img = $cell_img_array[$j][$i];
                imagecopy($img, $cell_img, $i * $cell_w, $j * $cell_h, 0, 0, $cell_w, $cell_h);
            }
        }
        return $img;
    }
    return 0;
}

/*
 * Scrambles the contents of $img using 10 keys stored in array $keys
 * $keys contains 10 real numbers between 0.1 and 0.9
 * $factor determines how small the cell images will be
 */
function encrypt($img, $keys, $factor)
{
    $w = imagesx($img);
    $h = imagesy($img);

    $cell_w = ceil($factor * $w);
    $cell_h = ceil($factor * $h);

    //get inorder 2D array of $img
    $cell_img_array = decompose($img, $cell_w, $cell_h);

    //2D reverse
    for ($i = 0; $i < count($cell_img_array); $i++) {
        $cell_img_array[$i] = array_reverse($cell_img_array[$i]);
    }
    $cell_img_array = array_reverse($cell_img_array);

    //reverse odd rows
    for ($i = 0; $i < count($cell_img_array); $i++) {
        if ($i % 2 != 0) {
            $cell_img_array[$i] = array_reverse($cell_img_array[$i]);
        }
    }

    //even index delimiters must be even and odd index delimiters must be odd
    for ($i = 1; $i <= count($keys); $i++) {
        $delim[$i] = round($keys[$i - 1] * count($cell_img_array[0]));
        if ($i % 2 != 0) {
            if ($delim[$i] % 2 == 0) {
                $delim[$i]++;
            }
        } else {
            if ($delim[$i] % 2 != 0) {
                $delim[$i]++;
            }
        }
    }

    //swap columns using delims above
    for ($k = 1; $k <= count($keys); $k++) {
        for ($j = 0; $j < count($cell_img_array[0]) - $delim[$k]; $j++) {
            if (($k % 2 != 0 && $j % 2 != 0) || ($k % 2 == 0 && $j % 2 == 0)) {
                for ($i = 0; $i < count($cell_img_array); $i++) {
                    $tmp = $cell_img_array[$i][$j];
                    $cell_img_array[$i][$j] = $cell_img_array[$i][$j + $delim[$k]];
                    $cell_img_array[$i][$j + $delim[$k]] = $tmp;
                }
            }
        }
    }

    //even index delimiters must be even and odd index delimiters must be odd
    for ($i = 1; $i <= count($keys); $i++) {
        $delim[$i] = round($keys[$i - 1] * count($cell_img_array));
        if ($i % 2 == 0) {
            if ($delim[$i] % 2 != 0) {
                $delim[$i]++;
            }
        } else {
            if ($delim[$i] % 2 == 0) {
                $delim[$i]++;
            }
        }
    }

    //swap rows using delims above
    for ($j = 1; $j <= count($keys); $j++) {
        for ($i = 0; $i < count($cell_img_array) - $delim[$j]; $i++) {
            if (($j % 2 != 0 && $i % 2 != 0) || $j % 2 == 0 && $i % 2 == 0) {
                $tmp = $cell_img_array[$i];
                $cell_img_array[$i] = $cell_img_array[$i + $delim[$j]];
                $cell_img_array[$i + $delim[$j]] = $tmp;
            }
        }
    }


    $img = reconstruct($cell_img_array);
    return $img;
}

/*
 * reverses the operations performed by encrypt() above
 * the keys used must be the same as the ones used to encrypt the image
 */
function decrypt($img, $keys, $factor)
{

    $cell_img_array = decompose($img, ceil($factor * imagesx($img)), ceil($factor * imagesy($img)));

    for ($i = 1; $i <= count($keys); $i++) {
        $delim[$i] = round($keys[$i - 1] * count($cell_img_array));

        if ($i % 2 == 0) {
            if ($delim[$i] % 2 != 0) {
                $delim[$i]++;
            }
        } else {
            if ($delim[$i] % 2 == 0) {
                $delim[$i]++;
            }
        }
    }

    for ($j = count($keys); $j >= 1; $j--) {
        for ($i = count($cell_img_array) - 1; $i >= $delim[$j]; $i--) {
            if ($i % 2 == 0) {
                $tmp = $cell_img_array[$i];
                $cell_img_array[$i] = $cell_img_array[$i - $delim[$j]];
                $cell_img_array[$i - $delim[$j]] = $tmp;
            }
        }

    }

    //even index delimiters must be even and odd index delimiters must be odd
    for ($i = 1; $i <= count($keys); $i++) {
        $delim[$i] = round($keys[$i - 1] * count($cell_img_array));
        if ($i % 2 == 0) {
            if ($delim[$i] % 2 != 0) {
                $delim[$i]++;
            }
        } else {
            if ($delim[$i] % 2 == 0) {
                $delim[$i]++;
            }
        }
    }

    for ($k = count($delim); $k > 0; $k--) {
        for ($j = count($cell_img_array[0]) - 1; $j >= $delim[$k]; $j--) {
            if ($j % 2 == 0) {
                for ($i = 0; $i < count($cell_img_array); $i++) {
                    $tmp = $cell_img_array[$i][$j];
                    $cell_img_array[$i][$j] = $cell_img_array[$i][$j - $delim[$k]];
                    $cell_img_array[$i][$j - $delim[$k]] = $tmp;
                }
            }
        }
    }

    //reverse odd rows
    for ($i = 0; $i < count($cell_img_array); $i++) {
        if ($i % 2 != 0) {
            $cell_img_array[$i] = array_reverse($cell_img_array[$i]);
        }
        $cell_img_array[$i] = array_reverse($cell_img_array[$i]);
    }

    $cell_img_array = array_reverse($cell_img_array);

    $img = reconstruct($cell_img_array);

    return $img;

}