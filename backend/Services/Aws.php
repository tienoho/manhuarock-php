<?php

namespace Services;

use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;


class Aws
{
    protected $client;
    protected $BucketName;
    protected $Hostname;
    protected $Endpoint;

    public function __construct()
    {
        // Endpoint URL
        $this->Endpoint = 'https://eu2.contabostorage.com';
        
        $this->client = new S3Client(
            [
                'region' => '',
                'version' => 'latest',
                'endpoint' => $this->Endpoint,
                'credentials' => [
                    'key' => 'c7475ce433634a738259a10e1920e619',
                    'secret' => '6a410a013c47f05f291cf9e484bee7de'
                ],
                // Set the S3 class to use objects.dreamhost.com/bucket
                // instead of bucket.objects.dreamhost.com
                'use_path_style_endpoint' => true
            ]);

        $this->BucketName = 'mangas';

        // CDN or Bucket URL
        $this->Hostname = 'https://eu2.contabostorage.com/2cc2cd6597164b5687be994540204a7a:mangas';
    }

    function upload($data, $path_to_upload)
    {
        try {
            $file = $this->client->putObject(
                [
                    'Bucket' => $this->BucketName,
                    'Key' => $path_to_upload,
                    'Body' => $data,
                    'ContentType' => 'image/jpeg',
                ]);

            $url = ($file->get('ObjectURL'));

            return str_replace("https://eu2.contabostorage.com/mangas", $this->Hostname, $url);
        } catch (S3Exception $e) {
            exit("There was an error uploading the file.\n");
        }
    }

    function delete()
    {

    }
}