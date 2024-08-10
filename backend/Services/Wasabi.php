<?php

namespace Services;

use Aws\S3\Exception\S3Exception;
use Aws\S3\S3Client;


class Wasabi
{
    public static $client;
    public static $config;

    public function __construct()
    {
        if (!self::$client || !self::$config) {
            self::$config = json_decode(file_get_contents(ROOT_PATH . '/config/wasabi.json'));

            self::$client = new S3Client(
                [
                    'region' => '',
                    'version' => 'latest',
                    'endpoint' => self::$config->Endpoint,
                    'credentials' => [
                        'key' => self::$config->key,
                        'secret' => self::$config->secret
                    ],
                    // Set the S3 class to use objects.dreamhost.com/bucket
                    // instead of bucket.objects.dreamhost.com
                    'use_path_style_endpoint' => true,
                    'use_aws_shared_config_files' => false,
                ]);
        }


    }

    function upload($data, $path_to_upload)
    {
        try {
            $file = self::$client->putObject(
                [
                    'Bucket' => self::$config->BucketName,
                    'Key' => $path_to_upload,
                    'Body' => $data,
                    'ACL' => 'public-read'

                ]);


            $url = ($file->get('ObjectURL'));
            if (!empty(self::$config->CDN)) {
                return str_replace(sprintf("%s/%s", self::$config->Endpoint, self::$config->BucketName), self::$config->CDN, $url);
            }

            return $url;
        } catch (S3Exception $e) {
            exit("There was an error uploading the file.\n");
        }
    }

    function delete()
    {

    }
}