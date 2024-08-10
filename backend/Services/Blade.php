<?php
namespace Services;

use Jenssegers\Blade\Blade as Template;

class Blade extends Template {

    protected $viewPath = ROOT_PATH. "/resources/views";
    protected $cachePath = ROOT_PATH. "/resources/cache/blade";

    public function __construct(){

        parent::__construct($this->viewPath, $this->cachePath);
    }
}

