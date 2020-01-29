<?php

class CrLogger {

    public static function log($logSystem, $logType, $logMessage) {

        date_default_timezone_set('Europe/Paris');

        $logDate = date("d.m.Y", time());
        $logTime = date("H:i:s", time());
        $logIp = getenv("REMOTE_ADDR");

        if ($logIp) {
            $logHost = strtr(gethostbyaddr(getenv("REMOTE_ADDR")), "'", "_");
        } else {
            $logIp = "-";
            $logHost = "-";
        }

        $user = CrLoginService::getLoggedInUser();

        if ($user) {
            $logUser = $user->getUserName();
        } else {
            $logUser = "anonymous";
        }

        if (CrConfig::logPath) {
            $fullFileName = CrConfig::logPath . "/" . date("Y_m", time()) . "_log.txt";

            $data = $logDate . "\t" . $logTime . "\t" . $logType . "\t" . $logSystem . "\t" . $logIp . "\t" . $logHost . "\t" . $logUser . "\t" . $logMessage . "\n";

            $file = fopen($fullFileName, "a+");
            fwrite($file, $data);
            fclose($file);
        }
    }

}

class CrLogType {

    const DEBUG = "Debug";
    const INFO = "Info";
    const WARNING = "Warning";
    const ERROR = "Error";

}
