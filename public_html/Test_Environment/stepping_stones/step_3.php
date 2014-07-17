<?php

include_once("step_header.php");

?>
<h3>Test 3 - Functions & Classes</h3>
<blockquote>
<code>
<!-- Function Setting -->
Set Function Hello_World(): <?php function Hello_World() { return "Hello World"; } if (Hello_World()=="Hello World") { echo "ok"; } else { echo "error"; } ?>

<!-- Class Setting -->
Define Class Hello_World: <?php class Hello_World { function __construct() { $this->hello_world(); } function hello_world() { return "Hello World"; }} $helloworld = new Hello_World(); if ($helloworld->hello_world()=="Hello World") { echo "ok"; } else { echo "error"; } ?>

</code>
</blockquote>
<?php

include_once("step_footer.php");

?>