<?php

function find_hook($plugin) {
	if (in_array($plugin,$_SERVER['Active9_Server_Plugin_Before_Triggers'])) {
		return "<font style=\"color:#00AA00;\">enabled</font>-><font style=\"color:#00AA00;\">before</font>";
	} else if (in_array($plugin,$_SERVER['Active9_Server_Plugin_Runtime_Triggers'])) {
		return "<font style=\"color:#00AA00;\">enabled</font>-><font style=\"color:#0000AA;\">runtime</font>";
	} else if (in_array($plugin,$_SERVER['Active9_Server_Plugin_After_Triggers'])) {
		return "<font style=\"color:#00AA00;\">enabled</font>-><font style=\"color:#AAAA00;\">after</font>";
	} else {
		return "<font style=\"color:#FF0000;\">disabled</font>";
	}
}

if (!isset($_GET['action'])) {
	$_GET['action'] = "";
}
if (!isset($_GET['value'])) {
	$_GET['value'] = "";
}


?>
<html>
<head>
<title>Active9 Server - Plugin Management</title>
 <style type="text/css" media="all">
  @import url("active9_server.css");
</style>
</head>
<body>
<blockquote>
<h1>Active9 Server - Plugin Management</h1>
<p><a href="http://www.active9.com/server/plugins/">Get More Plugins</a></p>
<blockquote>
	<p><b>Installed Active Server Plugins</b>
<ul>
<?php

foreach ($_SERVER['Active9_Server_Plugins_Loaded'] as $Plugin) {
	echo "<li style=\"list-style:square;\"><code>".$Plugin." :: hook->".find_hook($Plugin)."<div style=\"float:right;\"><a href=\"http://www.active9.com/server/plugins/".$Plugin."\" style=\"text-decoration:none;\">info</a></div></code></li>";
}

?>
</ul>
</p>
</blockquote>
<br />
<blockquote>
<h2>Removing An Installed Plugin</h2>
<blockquote>
<p>Step 1:</p>
<code>Open your active9_server/plugins/plugin.php file</code>
<p>Step 2:</p>
<code>Find the plugin name within the array list and remove it</code>
<p>Step 3:</p>
<code>Save your changes and refresh this page</code>
<p>Step 4 (Optional):</p>
<code>Erase the folder of the same plugin name from active9_server/plugins/</code>
</blockquote>
</blockquote>
<br />
<blockquote>
<h2>Installing A Plugin</h2>
<blockquote>
<p>Step 1:</p>
<code>Unzip the contents of your Active9 Server plugin</code>
<p>Step 2:</p>
<code>Extract the folder to your active9_server/plugins/ directory</code>
<p>Step 3:</p>
<code>Open your active9_server/plugins/plugin.php file</code>
<p>Step 4:</p>
<code>Add the folder name to the array list and then save the file</code>
<p>Step 5 (Optional):</p>
<code>Test your plugin or view if it is enabled by refreshing this page</code>
</blockquote>
</blockquote>
<br />
<blockquote>
<h2>Contribute</h2>
<blockquote>
<p>This project is Licensed GPLv3 & is 100% Open-Source.<br />Learn how you may contribute to it at <a href="http://www.active9.com/server/">active9.com/server</a></p>
</blockquote>
</blockquote>
<br />
<center><p style="font-size:12px;"><a href="http://www.active9.com/server/">Active9 Server</a> v<?php echo $_SERVER['Active9_Server_Version']; ?> is an Open-Source PHP Development Web Server Powered By: <a href="http://php.mirror.active9.com/manual/en/features.commandline.webserver.php">The PHP Development Web Server</a></p>
<p style="background:#FFFFFF;font-size:10px;">Active9 Server copyright 2012 Active9 LLC. PHP & The PHP Development Web Server copyright 2012 Zend Technologies Ltd.</p></center>
</blockquote>
</body>