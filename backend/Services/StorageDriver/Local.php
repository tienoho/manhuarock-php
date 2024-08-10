<?php

namespace Services\StorageDriver;

class Local implements StorageDriverInterface {
    public $config;
    public $url;

    

    public function __construct($config = [])
    {
        $this->config = $config;
        $site_config = include ROOT_PATH . '/config/site.php';

        if (empty($this->config)) {
            $this->config['root_path'] = ROOT_PATH . '/public/uploads';
            $this->config['base_url'] = $site_config['url'] . '/uploads';
        }
    }
    
    function put($file_path, $content) {
        // generate path if not exists
        $file_path = ltrim($file_path, '/');
        
        $path = $this->config['root_path'] . '/' . $file_path;

        $dir = dirname($path);
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }

        // write file
        file_put_contents($path, $content);

        $this->url = $this->config['base_url'] . '/' . $file_path;
    }

    // $files = [ 'path/to/file' => 'content', ... ] 
    public function multiPut($files) {
        foreach ($files as $file_path => $content) {
            $this->put($file_path, $content);
        }
    }

    public function getUrl()
    {
        return $this->url;
    }
}