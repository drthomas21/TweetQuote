<?php
class MessageLogger {
	private static function storeMessage($strMessage) {
		$strMessage = "[".date("H:i:s")."]".$strMessage."\r\n";
		if(defined('DEBUG') && DEBUG == true) {
			echo nl2br($strMessage);
		}
		
		$logFile = dirname(__FILE__)."/logs/logs-".date("Y-m-d").".log";
		try {
			$File = fopen($logFile, "a");
			if($File) {
				fwrite($File, $strMessage);
				fclose($File);
				return true;
			} else {
				$message = "Failed to open file for writing";
				error_log($message);
				echo $message;
			}
		} catch(Exception $e) {
			error_log($e->getMessage());
			echo $e->getMessage();
		}
		return false;
	}
	
	public static function logMessage($strMessage) {
		$bool = false;
		if(strlen($strMessage) > 0) {
			$bool = self::storeMessage($strMessage);
		}
		
		return $bool;
	}
}