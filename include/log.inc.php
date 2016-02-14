<?php

	function append_log($message) {
		$log = $_SERVER['DOCUMENT_ROOT'].'/log/log.txt';
		$content = PHP_EOL.time()."\t".$_SERVER['REMOTE_ADDR']." -\t".$message;
	 	file_put_contents($log, $content, FILE_APPEND);
	}

?>