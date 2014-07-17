<html>
<head>
<title>Active9 Server - Welcome</title>
 <style type="text/css" media="all">
  @import url("active9_server.css");
</style>
</head>
<body>
<blockquote>
<h1>Active9 Server</h1>
<p>A Portable PHP Development Web Server With Plugins!</p>
<blockquote>
	<p><br /><br />Active9 Server Version <?php echo $_SERVER['Active9_Server_Version']; ?> is up and running on <? echo $_SERVER['SERVER_NAME']; ?> port <? echo $_SERVER['SERVER_PORT']; ?> using PHP <? echo active9_server::$php_version; ?> Thread Safe: <? if (active9_server::$is_thread_safe) { echo "true\n"; } else { echo "false\n"; } ?><br /><br /><a href="http://www.active9.com/server/version_check.php?v=<?php echo $_SERVER['Active9_Server_Version']; ?>">Check For Updates</a> | <a href="plugin_management.php">Plugin Management</a> | <a href="php_info.php">PHP Info</a> |  <a href="http://php.mirror.active9.com">PHP Manual</a> |  <a href="Active9_Server_Manual">Active9 Server Manual</a></p>
</blockquote>
<br />
<center><img src="php_server_logo.png" border="0" alt="Active9 Server"></center>
<br />
<h2>Development Folders</h2>
<blockquote>
<ul>
<?php
$handle = opendir(getcwd());
while (false !== ($dir = readdir($handle))) {
	if (is_dir($dir)) {
		if (($dir!=".") & ($dir!="..")) {
			echo '<li><a href="'.$dir.'">'.$dir.'</a></li>';
		}
	}
}
?>
</ul>
</blockquote>
<br />
<h3>Plugins</h3>
<blockquote>
<ul>
	<p><a href="plugin_management.php">Plugin Management</a> | <a href="http://www.active9.com/server/plugins/">Get More Plugins</a></p>
	<li>At Startup<code><?php print_r($_SERVER['Active9_Server_Plugin_Before_Triggers']); ?></code></li>
	<li>During Runtime<code><?php print_r($_SERVER['Active9_Server_Plugin_Runtime_Triggers']); ?></code></li>
	<li>After Page Processing<code><?php print_r($_SERVER['Active9_Server_Plugin_After_Triggers']); ?></code></li>
</ul>
</blockquote>
<br />
<br />
<h3>Active9 $_SERVER Variables</h3>
<blockquote>
<ul>
<?php
foreach ($_SERVER as $s=>$v) {
	echo "	<li>".$s."<code>";
	print_r($v);
	echo "</code></li>";
}
?>
</ul>
</blockquote>
<center><p style="font-size:12px;"><a href="http://www.active9.com/server/">Active9 Server</a> v<?php echo $_SERVER['Active9_Server_Version']; ?> is an Open-Source PHP Development Web Server Powered By: <a href="http://php.mirror.active9.com/manual/en/features.commandline.webserver.php">The PHP Development Web Server</a></p>
<p style="background:#FFFFFF;font-size:10px;">Active9 Server copyright 2012 Active9 LLC. PHP & The PHP Development Web Server copyright 2012 Zend Technologies Ltd.</p></center>
<center>
<br />
<a href="http://www.active9.com/server/"><?php echo '<img src="' . $_SERVER['PHP_SELF'] .
     '' . active9_server_logo_guid() . '" alt="PHP Logo !" />'; ?></a>
<a href="http://www.php.net/"><?php echo '<img src="' . $_SERVER['PHP_SELF'] .
     '?=' . php_logo_guid() . '" alt="PHP Logo !" />'; ?></a>
</center></blockquote>
</body>