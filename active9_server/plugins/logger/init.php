<?php
// Active9 Server (http://www.active9.com/server)
// Copyright 2012-214 Active9 LLC
// LICENSE: GPL V3

class logger extends active9_server {
	public $plugin_name;
	public $plugin_version;
	public $plugin_author;
	public $plugin_server_version;
	public $plugin_hook;
	public $file_attachment_type_list;

	function __construct() {
		$this->plugin_name = "logger";
		$this->plugin_version = "1.0";
		$this->plugin_author = "Chris McCaulley <talkquazi@gmail.com>";
		$this->plugin_server_version = "1.0";
		$this->plugin_hook = "after";
	}

	function __plugin() {
		return $this->plugin_before_triggers = $this->register_plugin($this,$this->plugin_server_version,$this->plugin_hook);
	}

	static function __init() {
		// Run On Shutdown
		register_shutdown_function("logger::log_request");
	}

	static function log_request() {
		$currentdir = getcwd();
		chdir(self::$cwd);
		$file = "active9_server/logs/access.log";
		$file_handle = fopen($file,"a");
		$xo = 100;
		while (!flock($file_handle, LOCK_EX | LOCK_NB)) {
			if ($xo>100) {
				break;
			}
			usleep(round(rand(0, 100)*1000));
			$xo++;
		}
		if (filesize($file)>32000000) {
			$logint = 1;
			while($logint<100) {
				$newfile = str_replace(".log","".$logint.".log",$file);
				if (!file_exists($newfile)) {
					copy($file,str_replace(".log","".$logint.".log",$file));
					break;
				}
				$logint++;
			}			
			clearstatcache();
			fclose($file_handle);
			$file_handle = fopen($file,"w");
		}
		$logd = "".time()." [".$_SERVER['REMOTE_ADDR']."] ".$_SERVER['REQUEST_URI']."\r\n";
		fwrite($file_handle, $logd);
		fclose($file_handle);
		chdir($currentdir);
	}

}

?>
