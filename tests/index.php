<?php

require_once('../gehaxelt/fileLogger/Compatibility.php');
require_once('../gehaxelt/fileLogger/FileLogger.php');
require_once('../gehaxelt/fileLogger/PackageInfo.php');

use gehaxelt\fileLogger\Compatibility;
use gehaxelt\fileLogger\CompatibilityException;
use gehaxelt\fileLogger\FileLogger;
use gehaxelt\fileLogger\PackageInfo as FLPackageInfo;

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

echo '<pre>', print_r(FLPackageInfo::getInfo()), '</pre>';
