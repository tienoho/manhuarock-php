<?php

namespace Services;

use Google\Service\Drive;
use Google\Service\Drive\DriveFile;

class GDriver
{
    protected $service;
    protected $file;

    function __construct()
    {
        if (!$this->service) {
            $client = getClient();
            $this->service = new Drive($client);
        }

        $this->file = new DriveFile();
        $this->file->setParents(['1bbGjiBvf6eR2dTmiUqh3MB5csN1ofx8P']);
    }

    function upload($data)
    {
        $this->file->setName(uniqid() . '.jpg');
        $res = $this->service->files->create($this->file, [
            'data' => $data,
            'mimeType' => 'application/octet-stream',
            'uploadType' => 'media',
        ]);
        $id = $res->getId();

        if (!$id) {
            exit("Lỗi khi up ảnh");
        }


        return "https://lh3.googleusercontent.com/d/$id=s0";
    }

    function getlink($fileId)
    {
        $key = "$fileId.drive";
        $Services = Cache::load();
        $Cache = $Services->getItem(md5($key));
        if ($Cache->isHit()) {
            return $Cache->get();
        }

        $client = getClient();
        $driveService = new Drive($client);
        $params = array('fields' => 'thumbnailLink, webContentLink');

        $file = $driveService->files->get($fileId, $params);
        $link = ($file->getWebContentLink());

        $link = str_replace('=s220', '=s0', $link);

        $Cache->expiresAfter(60 * 60 * 1);
        $Cache->set($link);
        $Services->save($Cache);

        return $link;
    }
}