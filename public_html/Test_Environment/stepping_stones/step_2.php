<?php

include_once("step_header.php");

?>
<h3>Test 2 - Variables & Defines</h3>
<blockquote>
<code>
<!-- Variable Setting -->
Set Var $test2: <?php $test2 = "Hello World"; if ($test2=="Hello World") { echo "ok"; } else { echo "error"; } ?>

<!-- Define Setting -->
Define Test2: <?php define('Test2','Hello World'); if (Test2=="Hello World") { echo "ok"; } else { echo "error"; } ?>


</code>
</blockquote>
<?php

include_once("step_footer.php");

?>