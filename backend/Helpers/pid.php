<?php

class pid
{

    public $is_running = false;
    public $process_running = 0;
    protected $filename;

    function __construct($id = null)
    {
        $directory = ROOT_PATH . '/tmp/';
        $this->filename = $directory . basename($_SERVER['PHP_SELF']) . md5($id) . '.lock';

        if (is_writable($this->filename) || is_writable($directory)) {
            if (file_exists($this->filename)) {
                $this->is_running = true;
                $this->process_running = file_get_contents($this->filename) + 1;
                file_put_contents($this->filename, $this->process_running);
            }
        } else {
            die("Cannot write to pid file '$this->filename'. Program execution halted.n");
        }

        if (!$this->is_running) {
            file_put_contents($this->filename,  1);
        }

    }

    public function __destruct()
    {
        if (file_exists($this->filename) && is_writeable($this->filename)) {
            if($this->process_running <= 1){
                unlink($this->filename);
            } else {
                file_put_contents($this->filename,  $this->process_running - 1);
            }
        }

    }

}