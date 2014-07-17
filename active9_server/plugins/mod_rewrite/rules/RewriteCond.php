<?php
// Active9 Server (http://www.active9.com/server)
// Copyright 2012 Active9 LLC (Created By: Chris McCaulley <talkquazi@gmail.com>)
// LICENSE: GPL V3

class mod_rewrite_RewriteCond {
	private static $__constants;

	public function __construct() {
		$this->__constants();
	}

	public function __init($values) {
		if (mod_rewrite::$rewrite_engine_enabled==1) {
			$main_part = @explode(" ",trim($values));
			if (is_array($main_part)) {
				$main_part = $main_part[0];
			}

			if (preg_match("/\%/",$main_part)) {
				self::$__constants['REQUEST_FILENAME'] = basename($_SERVER['REQUEST_URI']);
				foreach (self::$__constants as $c => $v) {
					if (preg_match("/\%\{".$c."\}/",$values)) {
						mod_rewrite::$rewrite_rule_strings[] = $this->__rewrite_rule_cond(trim(str_replace("%{".$c."}",$v,$values)));
					}
				}
			}

		}
	}

	public function __constants() {
		self::$__constants = $_SERVER;
	}

	public function __rewrite_rule_cond($line) {
		$conditions = @explode(" ",$line);
		if (is_array($conditions)) {
			if (preg_match("/".str_replace('/','\/',str_replace('.','\.',addslashes(stripslashes($conditions[1]))))."/",$conditions[0])) {
				return $line;
			}
		}
		return "";
	}

}

?>