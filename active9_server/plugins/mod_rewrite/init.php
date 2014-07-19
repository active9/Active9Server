<?php
// Active9 Server (http://www.active9.com/server)
// Copyright 2012-214 Active9 LLC
// LICENSE: GPL V3

class mod_rewrite extends active9_server {
	public $plugin_name;
	public $plugin_version;
	public $plugin_author;
	public $plugin_server_version;
	public $plugin_hook;
	public static $ht_access_type_list;
	public static $rewrite_engine_enabled;
	public static $rulesets;
	public static $rewriteflags;
	public static $rewrite_rule_strings;

	function __construct() {
		$this->plugin_name = "mod_rewrite";
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
		self::$ht_access_type_list = array(
			'.htaccess'
		);
		self::$rewrite_engine_enabled = 0;
		self::access_request(self::$ht_access_type_list);
	}

	static function rewrite_ruleset() {
		static::$rulesets = array(
			'AddType',
			'AddHandler',
			'DirectoryIndex',
			'ErrorDocument',
			'IndexIgnore',
			'Options',
			'Redirect',
			'RewriteEngine',
			'RewriteBase',
			'RewriteCond',
			'RewriteRule'
		);
	}

	static function rewrite_flags() {
		static::$rewriteflags = array(
			'B' => '_escape_non_alpha',
			'C' => '_rule_chain',
			'DP' => '_discardpath',
			'E' => '_notsupported',
			'F' => '_forbidden',
			'G' => '_gone',
			'H' => '_notsupported',
			'L' => '_endprocess',
			'N' => '_restart',
			'NC' => '_caseinsensitive',
			'NE' => '_notsupported',
			'NS' => '_notsupported',
			'P' => '_notsupported',
			'PT' => '_passthrough',
			'QSA' => '_append',
			'QSD' => '_discard',
			'R' => '_redirect',
			'END' => '_endprocess',
			'S' => '_notsupported',
			'T' => '_forcemime'
		);
	}

	static function access_request($ht_access_list) {
		self::process_ht_access_file(self::propogate_ht_access_files());
	}

	static function propogate_ht_access_files() {
		self::rewrite_flags();
		self::rewrite_ruleset();
		$parsed_url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
		$parsed_url = @explode("/",$parsed_url);
		if (!is_array($parsed_url)) {
			$parsed_url = array('');
		}
		array_reverse($parsed_url);
		foreach ($parsed_url as $p) {
			if (is_dir($p)) {
				if ($handle = opendir($p)) {
					while (false !== ($entry = readdir($handle))) {
						if ($entry != "." && $entry != "..") {
							if (in_array($entry,self::$ht_access_type_list)) {
								return $p."/".$entry;
							}
						}
					}

				closedir($handle);
				}
			}
		}
		return "";
	}

	static function process_ht_access_file($file) {
		if (file_exists($file)) {
			$ht_handle = file_get_contents($file);
			if ($ht_handle!="") {
				$ht_handle = explode("\n",$ht_handle);
				foreach ($ht_handle as $ht) {
					$ht = trim(strip_tags($ht));
					if (($ht[0]!="#") && ($ht!="")) {
						$rule = self::match_ruleset($ht);
						if (trim($rule)!="") {
							$result = self::run_set($rule,$ht);
						}
					}
				}
			}
		}
	}

	static function match_ruleset($row) {
		$row = @explode(" ",$row);
		if (is_array($row)) {
			foreach (static::$rulesets as $rs) {
				if (preg_match("/".trim($row[0])."/",$rs)) {
					return $rs;
				}
			}
		}
	}

	static function run_set($rule,$values) {
		$values = str_replace($rule,"",$values);
		call_user_func("self::".$rule."",$values);
	}

	public static function __callStatic($name,$arguments) {
		$rule_file = "".self::$cwd."/active9_server/plugins/mod_rewrite/rules/".$name.".php";
		if (!file_exists($rule_file)) {
			die("Bad or Unsupported Ruleset ".$name." in your .htaccess file.");
		}
		include_once($rule_file);
		$write = "mod_rewrite_".$name;
		$rule = new $write;
		$rule->__init($arguments[0]);
	}
}

?>
