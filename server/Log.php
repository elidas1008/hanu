<?php

namespace server;

class Log{

    static private $fh = null;
    static private $ch = null;
    static private $doOutputToConsole = false;

    public static function debug($str, $printObjectAsJson = null) {

        if (isset($printObjectAsJson)) {
            $str .= json_encode($printObjectAsJson, JSON_PRETTY_PRINT);
        }
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

    static public function init($doOutputToConsole = true) {
        Log::$doOutputToConsole = $doOutputToConsole;
        Log::$fh = fopen("./log.txt", 'w');
        Log::$ch = fopen("php://stdout", 'w');
    }

    static public function destruct() {
        Log::$fh = fclose(Log::$fh);
    }

    static private function write($type, $str) {
        $dt = new \DateTime();
        $timestamp = $dt->format("Y-m-d H:i:s");
        $logLine = "$timestamp [$type]: $str". PHP_EOL;
        fwrite(Log::$fh, $logLine);
        if (Log::$doOutputToConsole) fwrite(Log::$ch, $logLine);
    }
}

Log::init(true);
