<?php

include_once("step_header.php");

?>
<h3>Test 10 - The Last Step - The Credits</h3>
<blockquote>
<code>
<!-- Credits -->
(&copy;) 2012 Active9 LLC. - All Rights Reserved

The Active9 Server is a GPLv3 licensed Open-Source
development server. http://active9.com/server

--( C R E D I T S )--

ACTIVE9 SERVER Credits

Active9 LLC.
Chris McCaulley (talkquazi@gmail.com)

<?php
ob_start();
phpcredits(CREDITS_ALL - CREDITS_FULLPAGE);
$contents = ob_get_contents();
ob_clean();
$contents = strip_tags($contents);
echo $contents;
?>

</code>
</blockquote>
<br /><br /><br />
<h3>Tests Complete!</h3>
<blockquote>
	The Active9 Server Test Environment testing has completed. Click the Next Text button to start over.
</blockquote>
<?php

include_once("step_footer.php");

?>