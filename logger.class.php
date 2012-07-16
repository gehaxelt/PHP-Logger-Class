<?php
include_once 'exceptions.logger.class.php';

/**
 * Logger class.
 * Usefull to log notices, warnings, errors or fatal errors into a logfile.
 * @author gehaxelt
 * @version 1.0
 */
class Logger {
	
	private $logfilehandle=NULL;
	
	const NOTICE=1;
	const WARNING=2;
	const ERROR=3;
	const FATAL=4;
	
	/**
	 * Contructor of Logger.
	 * Opens the new logfile
	 * @param string $logfile
	 */
	public function __construct($logfile) {
		if($this->logfilehandle==NULL)
			$this->OpenLogFile($logfile);
	}
	/**
	 * Destructor of Logger
	 */
	public function __destruct() {
		$this->CloseLogFile();
	}
	/**
	 * Logs the message into the logfile.
	 * @param string $message
	 * @param int $messageType
	 * @throws LogFileNotOpenException
	 * @throws NotAStringException
	 * @throws NotAIntegerException
	 * @throws InvalidMessageTypeException
	 */
	public function Log($message,$messageType=Logger::WARNING) {
		if($this->logfilehandle==NULL)
			throw new LogFileNotOpenException('Logfile is not opened.');
		
		if(!is_string($message))
			throw new NotAStringException('$message is not a string');
		
		if(!is_int($messageType))
			throw new NotAIntegerException('$messageType is not a integer');
		
		switch($messageType) {
			case Logger::NOTICE:
					$this->writeToLogFile("[".$this->getTime()."][NOTICE] - ".$message);
				break;
			case Logger::WARNING:
					$this->writeToLogFile("[".$this->getTime()."][!WARNING!] - ".$message);
				break;
			case Logger::ERROR:
					$this->writeToLogFile("[".$this->getTime()."][!!ERROR!!] - ".$message);
				break;
			case Logger::FATAL:
					$this->writeToLogFile("[".$this->getTime()."][!!!FATAL!!!] - ".$message);
				break;
			default:
				throw new InvalidMessageTypeException('Wrong $messagetype given');
		}
		
	}
	
	/**
	 * Writes content to the logfile
	 * @param string $message
	 */
	private function writeToLogFile($message) {
		fwrite($this->logfilehandle,$message."\n");
	}
	
	/**
	 * Returns the current timestamp in dd.mm.YYYY - HH:MM:SS format
	 * @return string with the current date
	 */
	private function getTime() {
		$now = time();
		return date("d.m.Y - H:i:s");
	}
	
	/**
	 * Closes the current logfile.
	 */
	public function CloseLogFile() {
		if($this->logfilehandle!=NULL) {
			fclose($this->logfilehandle);
			$this->logfilehandle=NULL;
		}
	}
	
	/**
	 * Opens a given Logfile and closes the old one before.
	 * @param string $logfile
	 * @throws LogFileOpenErrorException
	 */
	public function OpenLogFile($logfile) {
		$this->CloseLogFile();
		
		if(!file_exists($logfile))
			$this->createLogFile($logfile);
		
		try {
			$this->logfilehandle=fopen($logfile,"a");
		} catch (Exception $err) {
			throw new LogFileOpenErrorException('Could not open Logfile in append-mode');
		}
	} 
	
	/**
	 * Creates a new Logfile.
	 * @param string $fileName
	 * @throws LogFileAlreadyExistsException
	 * @throws FileCreationErrorException
	 */
	private function createLogFile($fileName) {
		if(file_exists($fileName))
			throw new LogFileAlreadyExistsException('Logfile already exists.');
		try {
			fclose(fopen($fileName,"w"));
		} catch (Exception $err) {
			throw new FileCreationErrorException('Could not create new file $filename');
		}
	}
}
?>