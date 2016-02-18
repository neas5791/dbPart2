<?php

	function append_log($message) {
		// set log file location
		$log = $_SERVER['DOCUMENT_ROOT'].'/log/log.txt';
		// set default timezone to Sydney
		date_default_timezone_set('Australia/Sydney');
		// add end of line and date time in YYYY/MM/DD HH:MM:SS format
		$date = PHP_EOL.date('Y/m/d h:i:s H', time());
		//$content = PHP_EOL.time()."\t".$_SERVER['REMOTE_ADDR']." -\t".$message;
		// concat message contents and date timestamp
		$content = $date."\t".$_SERVER['REMOTE_ADDR']." -\t".$message;
		// write to log
	 	file_put_contents($log, $content, FILE_APPEND);
	}
?>