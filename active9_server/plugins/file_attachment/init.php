<?php
// Active9 Server (http://www.active9.com/server)
// Copyright 2012 Active9 LLC (Created By: Chris McCaulley <talkquazi@gmail.com>)
// LICENSE: GPL V3

class file_attachment extends active9_server {
	public $plugin_name;
	public $plugin_version;
	public $plugin_author;
	public $plugin_server_version;
	public $plugin_hook;
	public static $file_attachment_type_list;

	function __construct() {
		$this->plugin_name = "file_attachment";
		$this->plugin_version = "1.0";
		$this->plugin_author = "Chris McCaulley <talkquazi@gmail.com>";
		$this->plugin_server_version = "1.0";
		$this->plugin_hook = "before";
	}

	function __plugin() {
		return $this->plugin_before_triggers = $this->register_plugin($this,$this->plugin_server_version,$this->plugin_hook);
	}

	static function __init() {
		// Plugin Content Here
		self::$file_attachment_type_list = array(
			'.zip',
			'.rar',
			'.gz',
			'.tar',
			'.dmg',
			'.exe',
			'.7z',
			'.mp3',
			'.mov',
			'.mp4',
			'.mkv',
			'.aiff',
			'.wav',
			'.midi',
			'.wav'
		);
		if (self::check_request(self::$file_attachment_type_list)=="1") {
			$parsed_url_path = substr(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH),1);
			header("Content-type: ".self::mime_content_type($parsed_url_path));
			echo file_get_contents($parsed_url_path);
			die("");
		}
	}

	static function check_request($attachment_type_list) {
		$file_extension = basename($_SERVER['REQUEST_URI']);
		$file_extension = strrev($file_extension);
		$file_extension = @explode(".",$file_extension);
		if (is_array($file_extension)) {
			$file_extension = ".".strrev($file_extension[0]);
		} else {
			return 0;
		}
		if (preg_match('/(?:'.implode("|",$attachment_type_list).')$/', $file_extension)) {
			return 1;
		}
		return 0;
	}

}

?>