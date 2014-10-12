<?php

require_once('../gehaxelt/fileLogger/FileLogger.php');

use gehaxelt\fileLogger\FileLogger;
use gehaxelt\fileLogger\FileLoggerException;

$log = new FileLogger(__DIR__.'/logs/example.log.php');

$log->log('Example Notice', FileLogger::NOTICE);
$log->log('Example Warning', FileLogger::WARNING);
$log->log('Example Error', FileLogger::ERROR);
$log->log('Example Fatal', FileLogger::FATAL);
