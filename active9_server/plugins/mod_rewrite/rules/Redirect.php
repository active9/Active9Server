<?php
// Active9 Server (http://www.active9.com/server)
// Copyright 2012 Active9 LLC (Created By: Chris McCaulley <talkquazi@gmail.com>)
// LICENSE: GPL V3

class mod_rewrite_RewriteRule {

	public function __construct() {

	}

	public function __init($values) {
		if (mod_rewrite::$rewrite_engine_enabled==1) {
			echo "".$values."<HR>";
		}
	}

}

?>