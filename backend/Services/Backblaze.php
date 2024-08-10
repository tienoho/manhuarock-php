<?php

namespace Services;

use BackblazeB2\Client;
use BackblazeB2\Http\Client as HttpClient;

class Backblaze
{
    protected $client;
    protected $BucketName;
    protected $Hostname;

    public function __construct()
    {
        $this->client = new Client(
            '44ebfc3bdba0',
            '00243af4810a3670477089ea313a9a102415a1a163', [
            'client' => new HttpClient(['exceptions' => false, 'verify' => false])
        ]);

        $this->BucketName = 'hoimetruyen';
        $this->Hostname = 'https://cdn.wibu.one/file/' . $this->BucketName . '/';
    }

    function upload($data, $path_to_upload)
    {
        $total_error = 0;
        while (true) {
            try {
                $file = $this->client->upload(
                    [
                        'BucketName' => $this->BucketName,
                        'FileName' => $path_to_upload,
                        'Body' => $data
                    ]);
            } catch (\Exception $e) {
                if ($total_error > 3) {
                    exit($e);
                }
                sleep(5);
                $total_error++;
                continue;
            }

            $name = $file->getName();

            if (isset($this->Hostname)) {
                return $this->Hostname . $name;
            }

            return false;
        }
    }

    function delete()
    {

    }
}