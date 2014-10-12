<?php

require_once('../gehaxelt/fileLogger/Compatibility.php');
require_once('../gehaxelt/fileLogger/FileLogger.php');

use gehaxelt\fileLogger\Compatibility;
use gehaxelt\fileLogger\CompatibilityException;
use gehaxelt\fileLogger\FileLogger;

try {
    $compat = Compatibility::check();
} catch(CompatibilityException $e){
    die($e->getMessage());
}

$log = new FileLogger(__DIR__.'/logs/example.log.php');

$log->log('Example Notice', FileLogger::NOTICE);
$log->log('Example Warning', FileLogger::WARNING);
$log->log('Example Error', FileLogger::ERROR);
$log->log('Example Fatal', FileLogger::FATAL);
