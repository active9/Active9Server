<?php

$session_status = session_status();
if ($session_status==0) {
	$session_status = "Disabled";
} else if ($session_status==1) {
	$session_status = "Enabled, But No Sessions Exist Yet.";
}
if (session_start()) {
	$session = "Session Created";
	$_SESSION['VarTest'] = "Hello Session World";
} else {
	$session = "Session Creation Failed";
}
$session_status_after = session_status();
if ($session_status_after==0) {
	$session_status_after = "Disabled";
} else if ($session_status_after==1) {
	$session_status_after = "Enabled, But No Sessions Exist Yet.";
} else if ($session_status_after==2) {
	$session_status_after = "Enabled, Session Running.";
}

include_once("step_header.php");

?>
<h3>Test 6 - Session Tests</h3>
<blockquote>
<code>
<!-- Session Testing -->
Session Test: <?php echo $session_status; ?><br />
Session Start: <?php echo $session; ?><br />
Session Variable Test: <?php if ($_SESSION['VarTest']=="Hello Session World") { echo "ok"; } else { echo "failed"; } ?><br />
Session Status: <? echo $session_status_after; ?>
</code>
</blockquote>
<?php

include_once("step_footer.php");

?>