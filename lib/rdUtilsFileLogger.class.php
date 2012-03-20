<?php

class rdUtilsFileLogger {

    private $file_name = false;

    public function __construct($file_name) {
        if (isset($file_name)) {
            $this->file_name = $file_name;
        } else {
            throw new Exception('File:' . $file_name . ' not exist');
        }
    }

    public function log($text) {
        if (sfContext::hasInstance()) {
            if (sfConfig::get('sf_environment') != 'prod') {
                file_put_contents($this->file_name, date('Ymd|H:i:s') . ':' . $text . ':' . PHP_EOL, FILE_APPEND);
            }
        }
    }

}