<?php

namespace Services;

class Discord
{
    public $WEBHOOK_KEY = [];
    public $KEY_NUM = 0;
    public $TOTAL_KEY = 0;

    public function __construct()
    {
        $this->WEBHOOK_KEY = file_get_contents( ROOT_PATH . "/backend/Config/discord-bot.txt");
        $this->WEBHOOK_KEY = explode("\n", $this->WEBHOOK_KEY);
        $this->WEBHOOK_KEY = array_filter($this->WEBHOOK_KEY, 'trim');

        $this->TOTAL_KEY = count($this->WEBHOOK_KEY);
    }

    function upload($data, $path_to_upload)
    {
        $webhooks_url = trim($this->WEBHOOK_KEY[$this->KEY_NUM]);

        $datafiles["file-0"] = [
            'name' => basename($path_to_upload),
            'data' => $data
        ];

        $ch = curl_init($webhooks_url);
        $ch = $this->buildMultiPartRequest($ch, uniqid(), [], $datafiles);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 0);
        $response = json_decode(curl_exec($ch), true);
        curl_close($ch);

        if(!isset($response['attachments'][0]['url'])){
            return false;
        }


        return $response['attachments'][0]['url'];
    }

    function buildMultiPartRequest($ch, $boundary, $fields, $files)
    {
        $delimiter = '-------------' . $boundary;
        $data = '';

        foreach ($fields as $name => $content) {
            $data .= "--" . $delimiter . "\r\n"
                . 'Content-Disposition: form-data; name="' . $name . "\"\r\n\r\n"
                . $content . "\r\n";
        }
        foreach ($files as $name => $content) {
            $data .= "--" . $delimiter . "\r\n"
                . 'Content-Disposition: form-data; name="' . $name . '"; filename="' . $content['name'] . '"' . "\r\n\r\n"
                . $content['data'] . "\r\n";
        }

        $data .= "--" . $delimiter . "--\r\n";

        curl_setopt_array($ch, [
            CURLOPT_POST => true,
            CURLOPT_HTTPHEADER => [
                'Content-Type: multipart/form-data; boundary=' . $delimiter,
                'Content-Length: ' . strlen($data)
            ],
            CURLOPT_POSTFIELDS => $data
        ]);

        return $ch;
    }

    function delete()
    {
        return true;
    }
}