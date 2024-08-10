<?php

namespace Services;

class Chevereto {
    public $config;

    public function __construct()
    {
        // http://mysite.com/api/1/upload/
        $this->config = [
            'key' => '7aeca8287caa1585ac2f1c8c41668af4',
            'api' => 'https://api.imgbb.com/1/upload',
        ];
    }

    function upload($data, $path_to_upload){
        if(empty($data)){
            return "https://cdn.discordapp.com/attachments/899172262870142996/987142433034862612/404.jpg";
        }

        $len=strlen(bin2hex($data))/2;

        if(round($len / 1024 / 1024,4) >= 32){
            return "https://cdn.discordapp.com/attachments/899172262870142996/987142433034862612/404.jpg";

        }

        $postData = [
            'key' => $this->config['key'],
            'format' => 'json',
            'image' => base64_encode($data)
        ];

        $res = $this->curl($postData);

        $res = json_decode($res);

        if(!isset($res->data->display_url)){
            print_r($res);
        }

        return ($res->data->display_url);

    }

    function resizeImage($sourceImage, $maxWidth, $maxHeight, $quality = 80)
    {
        // Obtain image from given source file.
        if (!$image = @imagecreatefromstring($sourceImage))
        {
            return $sourceImage;
        }

        // Get dimensions of source image.
        list($origWidth, $origHeight) = getimagesize($sourceImage);

        if ($maxWidth == 0)
        {
            $maxWidth  = $origWidth;
        }

        if ($maxHeight == 0)
        {
            $maxHeight = $origHeight;
        }

        // Calculate ratio of desired maximum sizes and original sizes.
        $widthRatio = $maxWidth / $origWidth;
        $heightRatio = $maxHeight / $origHeight;

        // Ratio used for calculating new image dimensions.
        $ratio = min($widthRatio, $heightRatio);

        // Calculate new image dimensions.
        $newWidth  = (int)$origWidth  * $ratio;
        $newHeight = (int)$origHeight * $ratio;

        // Create final image with new dimensions.
        $newImage = imagecreatetruecolor($newWidth, $newHeight);
        imagecopyresampled($newImage, $image, 0, 0, 0, 0, $newWidth, $newHeight, $origWidth, $origHeight);

        ob_start();
        imagejpeg($newImage, null, $quality);
        $image_data = ob_get_contents();
        ob_end_clean();
        // Free up the memory.
        imagedestroy($image);
        imagedestroy($newImage);

        return $image_data;
    }

    function curl($data)
    {
        $url = $this->config['api'];

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));

        $resp = curl_exec($curl);
        if(curl_errno($curl))
            echo 'Curl error: '.curl_error($curl);

        curl_close($curl);

        return $resp;
    }

}