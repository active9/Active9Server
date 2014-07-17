<?php

include_once("step_header.php");

?>
<h3>Test 9 - Assertion Tests</h3>
<blockquote>
<code>
<!-- ASSERTION Testing -->
(!) This test checks for the mysql_query command and asserts
    a failure if not found. If found will attempt a null
    connection and throw an error. This Assertion handler
    is provided by php.net/assert.

ASSERT TEST MYSQL_CONNECT:<?php 

// Active assert and make it quiet
assert_options(ASSERT_ACTIVE, 1);
assert_options(ASSERT_WARNING, 0);
assert_options(ASSERT_QUIET_EVAL, 0);

// Create a handler function
function my_assert_handler($file, $line, $code)
{
    echo "<hr>Assertion Failed:
        File '$file'<br />
        Line '$line'<br />
        Code '$code'<br /><hr />";
}

// Set up the callback
assert_options(ASSERT_CALLBACK, 'my_assert_handler');

// Make an assertion that should fail
if (!function_exists("mysql_query")) {
	assert('function_exists("mysql_query")');
} else {
	assert('mysql_query("")');
}

?>

</code>
</blockquote>
<?php

include_once("step_footer.php");

?>