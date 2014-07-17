<?php
// Active9 Server (http://www.active9.com/server)
// Copyright 2012 Active9 LLC (Created By: Chris McCaulley <talkquazi@gmail.com>)
// LICENSE: GPL V3

class error_pages extends active9_server {
	public $plugin_name;
	public $plugin_version;
	public $plugin_author;
	public $plugin_server_version;
	public $plugin_hook;
	public $file_attachment_type_list;

	function __construct() {
		$this->plugin_name = "error_pages";
		$this->plugin_version = "1.0";
		$this->plugin_author = "Chris McCaulley <talkquazi@gmail.com>";
		$this->plugin_server_version = "1.0";
		$this->plugin_hook = "after";
	}

	function __plugin() {
		return $this->plugin_before_triggers = $this->register_plugin($this,$this->plugin_server_version,$this->plugin_hook);
	}

	static function __init() {
		self::check_for_file();
	}

	static function check_for_file() {
		if (self::$was_not_found==1) {
			if (is_file($_SERVER['REQUEST_URI'])) {
				include_once("error_pages/missing_mime_type.php");
			} else {
				include_once("error_pages/404_not_found.php");
			}
		} else {
			$err = error_get_last();
			if (is_array($err)) {
				echo "<div style=\"float:left;clear:left;padding:15px;background:#FF0000;color:#FFFFFF;font-size:12px;font-family:verdana;\">Error Report:<code style=\"display:block;font-size:12px;font-family:monospace,sanserif;color:#000000;padding:15px;background:#ffffff;margin:15px;clear:left;white-space:pre;\">";
				print_r($err);
				echo "</code></div>";
			}
		}
	}

}

?>