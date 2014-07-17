<?php

include_once("step_header.php");

?>
<h3>Test 4 - Extensions</h3>
<blockquote>
<code>
<!-- Show Extensions -->
Extension List: <?php print_r(get_loaded_extensions()); ?>

</code>
</blockquote>
<?php

include_once("step_footer.php");

?>