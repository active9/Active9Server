<?php
// Active9 Server (http://www.active9.com/server)
// Copyright 2012 Active9 LLC (Created By: Chris McCaulley <talkquazi@gmail.com>)
// LICENSE: GPL V3

class benchmark_pages extends active9_server {
	public $plugin_name;
	public $plugin_version;
	public $plugin_author;
	public $plugin_server_version;
	public $plugin_hook;
	public static $file_benchmark_type_list;
	private static $phpfilesloaded;

	function __construct() {
		$this->plugin_name = "benchmark_pages";
		$this->plugin_version = "1.0";
		$this->plugin_author = "Chris McCaulley <talkquazi@gmail.com>";
		$this->plugin_server_version = "1.0";
		$this->plugin_hook = "after";
	}

	function __plugin() {
		return $this->plugin_before_triggers = $this->register_plugin($this,$this->plugin_server_version,$this->plugin_hook);
	}

	static function __init() {
		// Plugin Content Here
		self::$file_benchmark_type_list = array(
			'.html',
			'.php'
		);
		if (self::check_request()=="1") {
			$timetaken = self::stamp();
			$memoryusage = ceil(memory_get_peak_usage()/1024);
			self::$phpfilesloaded = intval(count(get_included_files())+count(get_required_files()));
			$postcount = intval(count($_POST));
			$getcount = intval(count($_GET));
			
			echo "<div style=\"border:1px solid #DDDDFF;clear:left;padding:10px;margin-top:30px;font-family:verdana;background:#CCCCFF;color:#000000;font-size:18px;\">Benchmark Results</div>";
			echo "<div style=\"padding:10px;font-size:12px;font-family:verdana;background:#EEEEFF;color:#000000;float:left;\">Time Taken</div><div style=\"padding:14px;background:#CCCCFF;color:#777777;font-family:verdana;font-size:17px;align:center;float:left;padding=left:30px;\">".$timetaken." seconds</div>";
			echo "<div style=\"padding:10px;font-size:12px;font-family:verdana;background:#EEEEFF;color:#000000;float:left;\">Memory Consumed</div><div style=\"padding:14px;background:#CCCCFF;color:#777777;font-family:verdana;font-size:17px;align:center;float:left;padding=left:30px;\">".$memoryusage."kb</div>";
			echo "<div style=\"padding:10px;font-size:12px;font-family:verdana;background:#EEEEFF;color:#000000;float:left;\">PHP Files Loaded</div><div style=\"padding:14px;background:#CCCCFF;color:#777777;font-family:verdana;font-size:17px;align:center;float:left;padding=left:30px;\">".self::$phpfilesloaded."</div>";
			echo "<div style=\"padding:10px;font-size:12px;font-family:verdana;background:#EEEEFF;color:#000000;float:left;\">Post Count</div><div style=\"padding:14px;background:#CCCCFF;color:#777777;font-family:verdana;font-size:17px;align:center;float:left;padding=left:30px;\">".$postcount."</div>";
			echo "<div style=\"padding:10px;font-size:12px;font-family:verdana;background:#EEEEFF;color:#000000;float:left;\">Get Count</div><div style=\"padding:14px;background:#CCCCFF;color:#777777;font-family:verdana;font-size:17px;align:center;float:left;padding=left:30px;\">".$getcount."</div>";
		}
	}

	static function check_request() {
		$parsed_url_path = substr(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH),1);
		$file_extension = basename($parsed_url_path);
		$file_extension = strrev($file_extension);
		$file_extension = @explode(".",$file_extension);
		if (is_array($file_extension)) {
			$file_extension = strrev($file_extension[0]);
		}
		if (($file_extension=="") || ($file_extension==".") || (is_dir($file_extension))) {
			$file_extension = basename(__FILE__);
			$file_extension = strrev($file_extension);
			$file_extension = @explode(".",$file_extension);
			if (is_array($file_extension)) {
				$file_extension = ".".strrev($file_extension[0]);
			}
		}
		if ($file_extension!="") {
			$file_extension = ".".$file_extension;
		}
		if (preg_match('/(?:'.implode("|",self::$file_benchmark_type_list).')$/', $file_extension)) {
			return 1;
		}
		return 0;
	}

	private static function microtime_fix() {
		$mfix = microtime();
		$mfix = explode(" ",$mfix);
		$mfix = $mfix[1].".".str_replace("0.","",$mfix[0]);
		return substr($mfix,0,-5);
	}

	private static function stamp() {
		$result = self::microtime_fix()-$_SERVER["REQUEST_TIME_FLOAT"];
		if ($result<5000) {
			return substr($result,0,-9);
		}
		return $result;
	}

}

?>