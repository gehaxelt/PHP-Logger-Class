<?php
include_once 'logger.class.php';

$log=new Logger("example.error.log");
$log->log('Example Notice',Logger::NOTICE);
$log->log('Example Warning',Logger::WARNING);
$log->log('Example Error',Logger::ERROR);
$log->log('Example Fatal',Logger::FATAL);
unset($log);

?>
