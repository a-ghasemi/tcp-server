<?php

namespace App;


class Logger
{
    private $error_engine;

    private $log_path;
    private $logfile_handle;

    public function __construct($log_path)
    {
        $this->log_path = $log_path;
        $this->error_engine = new ErrorThrower();
    }

    public function log($content){
        $this->open_logfile();
        $this->write_log($content);
        $this->close_logfile();
    }

    private function open_logfile(){
        $this->logfile_handle = fopen($this->log_path, "a+");
        if(!$this->logfile_handle) $this->error_engine->error("Unable to open file!");
    }

    private function write_log($content){
        if(!$this->logfile_handle) $this->error_engine->error("file is not open!");
        fwrite($this->logfile_handle, $content);
    }

    private function close_logfile(){
        if(!$this->logfile_handle) $this->error_engine->error("file is not open!");
        fclose($this->logfile_handle);
    }
}