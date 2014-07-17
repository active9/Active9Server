<?php

if (!isset($_GET['step'])) {
	$_GET['step'] = 1;
}
if (is_file("stepping_stones/step_".intval($_GET['step']).".php")) {
	include_once("stepping_stones/step_".intval($_GET['step']).".php");
} else {
	header("LOCATION: ./");
}

?>