<?php
namespace Services;

use CloudAtlas\Flyclone\Rclone;
use CloudAtlas\Flyclone\Providers\S3Provider;

class Flyclone {
    public function __construct()
    {

        $left_side = new S3Provider('myserver', [
            'REGION'            => '',
            'ENDPOINT'          => '',
            'ACCESS_KEY_ID'     => '',
            'SECRET_ACCESS_KEY' => '',
        ]);

        $rclone = new Rclone($left_side);

    }

}