<?php

namespace Services\StorageDriver;

interface StorageDriverInterface
{
    public function put($file_path, $content);

    // $files = [ 'path/to/file' => 'content', ... ] or [content, ...]
    public function multiPut($files);

    public function getUrl();
}