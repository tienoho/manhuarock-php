<?php

namespace Services;

class Postimage
{
    public $config;

    // Get api key https://postimages.org/login/api
    public function __construct()
    {
        $this->config = [
            'key' => '6f547799114e5ef4bcef18b9f85e36e3',
            'gallery' => 'hentainet.co',
            'o' => '2b819584285c102318568238c7d4a4c7',
            'm' => '59c2ad4b46b0c1e12d5703302bff0120',
            'version' => '1.0.1',
            'name' => "",
            'type' => 'jpg',
            'image' => null
        ];


    }

    function upload($data, $path_to_upload)
    {

        foreach ($this->slipImage($data) as $img) {
            $this->config['image'] = base64_encode($img);
            $this->config['name'] = uniqid('image_');
            $this->config['type'] = 'jpg';

            $res = $this->curl($this->config);

            $get = explode_by("<hotlink>", "</hotlink>", $res);

            if (!$get) {
                exit("Lỗi khi up ảnh");
            }

            $image[] = $get;

        }

        return $image;
    }

    function curl($data)
    {
        $url = "http://api.postimage.org/1/upload";

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

//        $headers = array(
//            "Content-Type: application/x-www-form-urlencoded",
//        );
//        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        //for debug only!
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));

        $resp = curl_exec($curl);
        if(curl_errno($curl))
            echo 'Curl error: '.curl_error($curl);

        curl_close($curl);

        return $resp;
    }

    function slipImage($data)
    {

        $width = 5000;
        $height = 10000;
        $source = @imagecreatefromstring($data);
        $source_width = imagesx($source);
        $source_height = imagesy($source);
        $col = 0;
        $image = [];

        if($source_height < $height){
            $image[] = $data;
            imagedestroy($source);

            return  $image;
        }
        for ($row = 0; $row < $source_height / $height; $row++) {
            $last_row = $row;
        }

        for ($row = 0; $row < $source_height / $height; $row++) {
            $height1 = $height;
            if($row === $last_row){
                $height1 = $source_height - $height*($row);
            }

            $im = @imagecreatetruecolor($source_width, $height1);
            imagecopyresized($im, $source, 0, 0, $col * $width, $row * $height, $width, $height, $width, $height);
            ob_start();
            imagejpeg($im);
            $image[] = ob_get_contents();
            ob_end_clean();
            imagedestroy($im);
            if($row == $last_row){
                break;
            }
        }

        return $image;
    }
}