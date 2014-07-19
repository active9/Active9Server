<?php
// Active9 Server (http://www.active9.com/server)
// Copyright 2012-214 Active9 LLC
// LICENSE: GPL V3

class mod_rewrite_RewriteEngine extends active9_server {

	public function __construct() {

	}

	public function __init($values) {
		if (trim($values)=="On") {
			mod_rewrite::$rewrite_engine_enabled = 1;
		} else {
			mod_rewrite::$rewrite_engine_enabled = 0;
		}
	}

}

?>
