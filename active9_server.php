<?php
// Active9 Server (http://www.active9.com/server)
// Copyright 2012 Active9 LLC (Created By: Chris McCaulley <talkquazi@gmail.com>)
// LICENSE: GPL V3
/*

	Active9 Server - Version 1.1
	Utilizing The PHP-CLI Development Server
	---------------------------------------------------------------------------------------------
	This is a highly experimental development server is designed to run in php 5.4.0 and greater

	[Installation]
		Active9 Server is designed to be fully portable. You may install it to any directory or
		device as you wish however, here are some tips to help you get started.

		[Windows Install]
		Install Active9 Server on Windows
			- Download PHP 5.4.0 or newer from php.net
			- Install To Your Desktop As /PHP/
			- Copy The Files From Active9_Server_Windows.zip to the /PHP/ directory
			- Open/Run The active9_server.bat file
			- Accept any network security alerts your system may prompt you for.
			- Point your browser to http://localhost/

		[Linux Install]
		Install Active9 Server on Linux
			- Download & Compile PHP 5.4.0 or newer
			- Copy The Files From Active9_Server_Windows.zip to /home/Active9Server/
			- Chmod the active9_server.sh file as writable (chmod +x active9_server.sh)
			- Point your browser to 127.0.0.1

	[Configuration]
		Active9 Server is easily configurable. The main service runs off of the launch
		script for each individual Operating System. That main configuration file is
		either a .bat or a .sh file. You can specify the host and port as well as the
		initial launch script inside the main configuration launch script.

		By Default the Active9 Server launch script will bind to any available ip on
		port 80. This port may conflict with other services such as skype or other web servers.	

		The second place to look for configuration files is within the active9_server/config
		folder. Inside that folder you will find the main .ini file. This file controls which
		files are considered index files, scripts that should parse as php, and other settings.

	[Warning] -- DO NOT USE ON A PRODUCTION SERVER --
		Active9 Server is free open-source technology licensed under the GPL V3 license.
		This server is for development purposes only and should not be used in a production
		environment. Active9 LLC will not be held responsible for any damages done to your
		system or services as the result of running this server. Use at your own risk. Altho
		we have taken measures to ensure the product is fully tested as it was intented to
		be used. If you encounter any bugs or would like to contribute to the project then
		contact talkquazi@gmail.com be sure to note you are inquiring about Active9 Server.
		The project page for this server can be found at http://www.active9.com/server/

	---------------------------------------------------------------------------------------------
*/
class active9_server {
	public $version = "1.2";
	private $plugins;
	private $config;
	private $index_list;
	private $php_type_list;
	private $mime_type_list;
	private static $mime_types;
	private $mimes;
	private $plugins_loaded;
	public static $was_not_found;
	public static $php_version;
	public $stdout;
	private static $bufersize;
	public static $is_thread_safe;
	public static $cwd;

	function __construct() {
		self::$is_thread_safe = $this->detect_thread_saftey();
		$this->buffersize = "2048";
		$this->stdout = fopen('php://stdout', 'w');
		self::$php_version = phpversion();
		$this->php_validate();
		self::$was_not_found = 0;
		$_SERVER['Active9_Server_Version'] = $this->version;
		$_SERVER['Active9_Server_Plugins'] = "";
		$_SERVER['Active9_Server_Plugins_Loaded'] = "";
		$_SERVER['Active9_Server_Plugin_Before_Triggers'] = array();
		$_SERVER['Active9_Server_Plugin_Runtime_Triggers'] = array();
		$_SERVER['Active9_Server_Plugin_After_Triggers'] = array();
		$this->plugins_loaded = array();
		$this->config = $this->load_configuration();
		error_reporting($this->config['error_reporting']);
		$this->console_write("Request From: ".$_SERVER['REMOTE_ADDR']."\nRequested: ".addslashes($_SERVER['REQUEST_URI'])."\n");
		$this->load_index_files();
		$this->load_php_type_list();
		$this->load_mime_type_list();
		$this->load_mime_types();
		$this->plugin_before_triggers = $this->load_plugins();
		self::$cwd = getcwd();
		chdir($this->config['web_root']);
		$_SERVER['DOCUMENT_ROOT'] = $_SERVER['DOCUMENT_ROOT']."/".$this->config['web_root'];
		$this->fork_();
		$_SERVER['SERVER_SOFTWARE'] = "Active9 Server ".$this->version." - Powered By The PHP Development Server";
		$this->request_rewrite($this->plugin_before_triggers);
	}

	function detect_thread_saftey() {
		if (ini_get('enable_dl')) {
			return ini_get('enable_dl');
		}
		return false;
	}

	function console_write($value) {
		if ($this->config['console_enabled']=="1") {
			return fwrite($this->stdout,$value);
		}
	}

	function php_validate() {
		if (self::$php_version<"5.4") {
			die("PHP Version 5.4 or greater is required");
		}
	}

	function version() {
		return $this->version;
	}

	function load_configuration() {
		return parse_ini_file("active9_server/config/config.ini");
	}

	function load_index_files() {
		$this->index_list = $this->config['index_files'];
	}

	function load_php_type_list() {
		$this->php_type_list = $this->config['php_type_list'];
	}

	function load_mime_type_list() {
		$this->mime_type_list = $this->config['mime_type_list'];
	}

	function load_mime_types() {
		include_once("active9_server/mime/mimes.php");
		$this->mimes = new mimes();
		self::$mime_types = $this->mimes->listmimes();
	}

	function register_plugin($context,$minver,$hook) {
		$this->render_plugin($context,$hook);
		if (is_array($_SERVER['Active9_Server_Plugins_Loaded'])) {
			$this->plugins_loaded = array_merge(array($context->plugin_name),$_SERVER['Active9_Server_Plugins_Loaded']);
		} else {
			$this->plugins_loaded = array($context->plugin_name);
		}
		$_SERVER['Active9_Server_Plugins_Loaded'] = $this->plugins_loaded;
	}

	function render_plugin($context,$hookto) {
		if ($hookto=="before") {
			// Before Output Hooking (Run Right Away)
			if (is_array($_SERVER['Active9_Server_Plugin_Before_Triggers'])) {
				$_SERVER['Active9_Server_Plugin_Before_Triggers'] = array_merge(array($context->plugin_name),$_SERVER['Active9_Server_Plugin_Before_Triggers']);
			} else {
				$_SERVER['Active9_Server_Plugin_Before_Triggers'] = array($context->plugin_name);
			}
		} else if ($hookto=="runtime") {
			// During Runtime Output Hooking
			if (is_array($_SERVER['Active9_Server_Plugin_Runtime_Triggers'])) {
				$_SERVER['Active9_Server_Plugin_Runtime_Triggers'] = array_merge(array($context->plugin_name),$_SERVER['Active9_Server_Plugin_Runtime_Triggers']);
			} else {
				$_SERVER['Active9_Server_Plugin_Runtime_Triggers'] = array($context->plugin_name);
			}
		} else {
			// After Output Hooking
			if (is_array($_SERVER['Active9_Server_Plugin_After_Triggers'])) {
				$_SERVER['Active9_Server_Plugin_After_Triggers'] = array_merge(array($context->plugin_name),$_SERVER['Active9_Server_Plugin_After_Triggers']);
			} else {
				$_SERVER['Active9_Server_Plugin_After_Triggers'] = array($context->plugin_name);
			}
		}
	}

	function __render_before_triggers() {
		if (is_array($_SERVER['Active9_Server_Plugin_Before_Triggers'])) {
			foreach ($_SERVER['Active9_Server_Plugin_Before_Triggers'] as $p) {
				$p::__init();
			}
		}
	}

	function __render_runtime_triggers() {
		if (is_array($_SERVER['Active9_Server_Plugin_Runtime_Triggers'])) {
			foreach ($_SERVER['Active9_Server_Plugin_Runtime_Triggers'] as $p) {
				$p::__init();
			}
		}
	}

	function __render_after_triggers() {
		if (is_array($_SERVER['Active9_Server_Plugin_After_Triggers'])) {
			foreach ($_SERVER['Active9_Server_Plugin_After_Triggers'] as $p) {
				$p::__init();
			}
		}
	}

	function load_plugins() {
		$this->plugins = array();
		include_once("active9_server/plugins/plugin.php");
		foreach ($_SERVER['Active9_Server_Plugins'] as $ap) {
			if (is_file("active9_server/plugins/".$ap."/init.php")) {
				include_once("active9_server/plugins/".$ap."/init.php");
				if (class_exists($ap)) {
					$this->plugins[$ap] = new $ap;
					$this->plugins[$ap]->__plugin();
				} else {
					die("Plugin Error: Class ".$ap." not found.");
				}
			} else {
				die("Plugin Error: Could not load the plugin ".$ap."");
			}
		}
	}

	function request_rewrite() {
		$IRU = strrev($_SERVER['REQUEST_URI']);
		$parsed_url_path = substr(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH),1);
		$this->__render_before_triggers();
		if ($IRU[0]=="/") {
			$loop_indexes = @explode(",",$this->index_list);
			if (is_array($loop_indexes)) {
				foreach ($loop_indexes as $li) {
					if (is_file($li)) {
						if ($_SERVER['REQUEST_URI']=="/") {
							include_once($li);
							$this->__render_runtime_triggers();
							break;
						} else {
							self::$cwd = getcwd();
							$workingdir = $this->fix_working_directory($parsed_url_path);
							$incfile = str_replace($li,"",$parsed_url_path).$li;
							if (is_file(self::$cwd."/".$incfile)) {
								include_once(self::$cwd."/".$incfile);
								$this->__render_runtime_triggers();
								self::$was_not_found = 0;
								break;
							} else {
								self::$was_not_found = 1;
							}
						}
					} else {
						self::$was_not_found = 1;
					}
				}
			}
		} else if (preg_match('/\.(?:'.str_replace(",","|",$this->index_list).')$/', $_SERVER['REQUEST_URI'])) {
			if (is_file($parsed_urL_path)) {
				self::$cwd = getcwd();
				$workingdir = $this->fix_working_directory($parsed_url_path);
				include_once(basename($parsed_url_path));
				chdir(self::$cwd);
				$this->__render_runtime_triggers();
			} else {
				self::$was_not_found = 1;
			}
		} else if (preg_match('/\.(?:'.str_replace(",","|",$this->php_type_list).')$/', $parsed_url_path)) {
			if (is_file($parsed_url_path)) {
				self::$cwd = getcwd();
				$workingdir = $this->fix_working_directory($parsed_url_path);
				include_once(basename($parsed_url_path));
				chdir(self::$cwd);
				$this->__render_runtime_triggers();
			} else {				
				self::$was_not_found = 1;
			}
		} else if (preg_match('/\.(?:'.str_replace(",","|",$this->mime_type_list).')$/', $parsed_url_path)) {
			if (is_file($parsed_url_path)) {
				header("Content-type: ".$this->mime_content_type($parsed_url_path));
				echo file_get_contents($parsed_url_path);
				self::$was_not_found = 0;
			} else if (is_dir($parsed_url_path)) {
				header("LOCATION: ".$parsed_url_path."/");
				self::$was_not_found = 0;
			} else {
				self::$was_not_found = 1;
			}
		} else if (is_dir($parsed_url_path)) {
			header("LOCATION: ".$parsed_url_path."/");
		} else {
			self::$was_not_found = 1;
		}
		$this->__render_after_triggers();
	}

	function fix_working_directory($working_file) {
		if (is_dir($working_file)) {
			chdir(self::$cwd."/".$working_file);
		} else {
			$working_filex = pathinfo($working_file);
			$working_filex = $working_filex['dirname']."/".basename($working_file);
			chdir(self::$cwd."/".dirname($working_filex));
		}
		return dirname($working_file);
		
	}

	function mime_content_type($file) {
		$filemime = strrev($file);
		$filemime = @explode(".",$filemime);
		$filemime = strrev($filemime[0]);
		return self::$mime_types[''.$filemime.''];
	}

	function fork_() {
		if (function_exists("pcntl_fork")) {
			$pid = pcntl_fork();
			if ($pid == -1) {
				die("Internal Server Errpr: Could Not Fork");
			} else if ($pid) {
				pcntl_wait($status);
			} else {
				setproctitle("active9server");
				return;
			}
		} else {
			return;
		}
	}

	function phpinfo() {
		ob_start();
		echo phpinfo();
		$contents = ob_get_contents();
		ob_clean();
		
		// Rewrite the Server API Info
		$contents = str_replace("Built-in HTTP server","Active9 Server - Version ".$this->version."",$contents);

		// Rewrite the powered by tagline
		$contents = str_replace("This program makes use","Running Active9 Server - Version ".$this->version." (Do Not Use In A Production Environment!)<br />This program makes use",$contents);

		// Rewrite the php Version Title & Tags
		$contents = str_replace("PHP Version ".self::$php_version."","PHP Version ".self::$php_version." / Active9 Server ".$this->version."",$contents);
		return $contents;
	}

}

function active9_server_logo_guid() {
	return "active9_server.gif";
}

if (php_sapi_name()==="cli-server") {
	new active9_server();
} else {
	echo "Active9 Server - Fatal Error! - This script must be run as a php cli-server router script via the provided .sh or .bat file";
}

?>