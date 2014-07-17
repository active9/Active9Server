<?php

include_once("step_header.php");

?>
<h3>Test 1 - For & While Loops</h3>
<blockquote>
<code>
<!-- 100 For Loops -->
Running 100 For Loops: <?php for ($i = 1; $i <= 100; $i++) {} if ($i==101) { echo "ok"; } else { echo "error"; } ?>

<!-- 100 For Loops -->
Running 100 While Loops: <?php $i = 0; while ($i <= 100) {$i++;} if ($i==101) { echo "ok"; } else { echo "error"; } ?>


</code>
</blockquote>
<?php

include_once("step_footer.php");

?>