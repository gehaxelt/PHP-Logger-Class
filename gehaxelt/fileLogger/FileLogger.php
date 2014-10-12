<?php

namespace gehaxelt\fileLogger {
    
    use Exception;
    
    class FileLoggerException extends Exception {}
    
    /**
     * File logger
     * 
     * Log notices, warnings, errors or fatal errors into a log file.
     * 
     * @author gehaxelt
     * @version 1.1
     */
    class FileLogger {
        
        /**
         * Holds the file handle.
         * 
         * @var resource
         */
        protected $fileHandle = NULL;
        
        /**
         * The time format to show in the log.
         * 
         * @var string
         */
        protected $timeFormat = 'd.m.Y - H:i:s';
        
        /**
         * The file permissions.
         */
        const FILE_CHMOD = 756;
        
        const NOTICE = '[NOTICE]';
        const WARNING = '[WARNING]';
        const ERROR = '[ERROR]';
        const FATAL = '[FATAL]';
        
        /**
         * Opens the new logfile
         * 
         * @param string $logfile The path to the loggable file.
         */
        public function __construct($logfile) {
            if($this->fileHandle == NULL){
                $this->openLogFile($logfile);
            }
        }
        
        /**
         * Closes the file handle.
         */
        public function __destruct() {
            $this->closeLogFile();
        }
        
        /**
         * Logs the message into the log file.
         * 
         * @param  string $message     The log message.
         * @param  int    $messageType Optional: urgency of the message.
         */
        public function log($message, $messageType = FileLogger::WARNING) {
            if($this->fileHandle == NULL){
                throw new FileLoggerException('Logfile is not opened.');
            }
            
            if(!is_string($message)){
                throw new FileLoggerException('$message is not a string');
            }
            
            if($messageType != FileLogger::NOTICE &&
               $messageType != FileLogger::WARNING &&
               $messageType != FileLogger::ERROR &&
               $messageType != FileLogger::FATAL
            ){
                throw new FileLoggerException('Wrong $messagetype given.');
            }
            
            $this->writeToLogFile("[".$this->getTime()."]".$messageType." - ".$message);
        }
        
        /**
         * Writes content to the log file.
         * 
         * @param string $message
         */
        private function writeToLogFile($message) {
            flock($this->fileHandle, LOCK_EX);
            fwrite($this->fileHandle, $message.PHP_EOL);
            flock($this->fileHandle, LOCK_UN);
        }
        
        /**
         * Returns the current timestamp.
         * 
         * @return string with the current date
         */
        private function getTime() {
            return date($this->timeFormat);
        }
        
        /**
         * Closes the current logfile.
         */
        protected function closeLogFile() {
            if($this->fileHandle != NULL) {
                fclose($this->fileHandle);
                $this->fileHandle = NULL;
            }
        }
        
        /**
         * Opens a file handle.
         * 
         * @param string $logFile Path to log file.
         */
        public function openLogFile($logFile) {
            $this->closeLogFile();
            
            if(!is_dir(dirname($logFile))){
                if(!mkdir(dirname($logFile), FileLogger::FILE_CHMOD, true)){
                    throw new FileLoggerException('Could not find or create directory for log file.');
                }
            }
            
            if(!$this->fileHandle = fopen($logFile, 'a+')){
                throw new FileLoggerException('Could not open file handle.');
            }
        } 
        
        /**
         * Convenience function to wrap FileLogger->log($message, $messagetype);
         * 
         * @param string $message
         */
        public function notice($message) {
            $this->log($message, FileLogger::NOTICE);
        }
        
        /**
         * Convenience function to wrap FileLogger->log($message, $messagetype);
         * 
         * @param string $message
         */
        public function warn($message) {
            $this->log($message, FileLogger::WARNING);
        }
        
        /**
         * Convenience function to wrap FileLogger->log($message, $messagetype);
         * 
         * @param string $message
         */
        public function error($message) {
            $this->log($message, FileLogger::ERROR);
        }
        
        /**
         * Convenience function to wrap FileLogger->log($message, $messagetype);
         * 
         * @param string $message
         */
        public function fatal($message) {
            $this->log($message, FileLogger::FATAL);
        }
        
    }
    
}
