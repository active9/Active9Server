<?php

include_once("step_header.php");

?>
<h3>Test 7 - Logo Suit GUID Tests</h3>
<blockquote>
<code>
<!-- GUID Testing -->
ACTIVE9 SERVER GUID Test: <a href="http://www.active9.com/server/"><?php echo '<img src="../' . active9_server_logo_guid() . '" alt="PHP Logo !" />'; ?></a>

PHP GUID TEST: <a href="http://www.php.net/"><?php echo '<img src="' . $_SERVER['PHP_SELF'] .
     '?=' . php_logo_guid() . '" alt="PHP Logo !" />'; ?></a>

ZEND GUID TEST: <a href="http://www.zend.com/"><?php echo '<img src="' . $_SERVER['PHP_SELF'] .
     '?=' . zend_logo_guid() . '" alt="Zend Logo !" />'; ?></a>

</code>
</blockquote>
<?php

include_once("step_footer.php");

?>