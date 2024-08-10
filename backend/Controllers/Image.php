<?php

namespace Controllers;

class Image
{
    public function uncramble()
    {
        $url = $_GET['url'] ?? null;
        if (!$url) {
            return 'Missing url parameter';
        }

    }

}
