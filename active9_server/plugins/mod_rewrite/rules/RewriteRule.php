<?php
// Active9 Server (http://www.active9.com/server)
// Copyright 2012 Active9 LLC (Created By: Chris McCaulley <talkquazi@gmail.com>)
// LICENSE: GPL V3

class mod_rewrite_RewriteRule {

	public function __construct() {

	}

	public function __init($values) {
		if (mod_rewrite::$rewrite_engine_enabled==1) {
			if (count(mod_rewrite::$rewrite_rule_strings)>1) {

			} else {
				$this->__rewrite_condition($values);
			}
		}
	}

	public function __rewrite_condition($string) {
			$string = @explode(" ",trim($string));
			if (preg_match("/".$string[0]."/",$_SERVER['REQUEST_URI'],$matches)) {
				$n=1;
				foreach ($matches as $m) {
					$string[1] = str_replace("=".$n,"=".$m,$string[1]);
				$n++;
				}


			// TODO [L,QSA] hatching and multiple rewrite conditions
				
			// Super Request Rewrite Sub
				$urlparts = parse_url($_SERVER['REQUEST_URI']);
				$string[1] = $urlparts['path'].$string[1];
				///echo "Before: ".$_SERVER['REQUEST_URI']."<HR>";
				$_SERVER['REQUEST_URI'] = $string[1];

				//echo "After: ".$_SERVER['REQUEST_URI']."<HR>";
				//$this->request_rewrite();
				//die("");
				//	echo "".$string[1]." with conditions <blockquote>";
				//	print_r(mod_rewrite::$rewrite_rule_strings);
				//	echo "</blockquote></hr>";
			}
	}

}

?>