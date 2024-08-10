<?php

namespace Services;


class Local
{
    protected $rootPath;


    public function __construct()
    {
        $this->rootPath = ROOT_PATH. '/public/uploads/';
        $this->hostPath = getConf('site')['site_url'] . '/uploads/';

    }

    function upload($data, $path_to_upload)
    {

        $directory = dirname($this->rootPath. $path_to_upload);

        if(!is_dir($directory)){
            //Create our directory.
            mkdir($directory, 755, true);
        }

        if(file_put_contents($this->rootPath . $path_to_upload, $data) !== false){
            return $this->hostPath . $path_to_upload;
        }

        return false;
    }

    function delete()
    {

    }
}