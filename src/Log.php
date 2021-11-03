<?php

class Log{

    static private $fh = null;

    public static function debug($str) {
        Log::write("DEBUG", $str);
    }
    public static function info($str) {
        Log::write("INFO", $str);
    }
    public static function warn($str) {
        Log::write("WARN", $str);
    }
    public static function err($str) {
        Log::write("ERR", $str);
    }

    static public function init() {
        Log::$fh = fopen("./log.txt", 'w');
    }

    static public function destruct() {
        Log::$fh = fclose(Log::$fh);
    }

    static private function write($type, $str) {
        $dt = new DateTime();
        $timestamp = $dt->format("Y-m-d H:i:s");
        $logLine = "$timestamp [$type]:: $str". PHP_EOL;
        fwrite(Log::$fh, $logLine);
    }
}

// $log = new Log(true);
