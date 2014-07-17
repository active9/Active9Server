<?php

include_once("step_header.php");

?>
<h3>Test 8 - PHP INI Tests</h3>
<blockquote>
<code>
<!-- PHP INI Testing -->
PHP INI FILE:<?php 

$inipath = php_ini_loaded_file();

if ($inipath) {
    echo ' Loaded: '.$inipath.'.ini';
} else {
    echo ' php.ini Missing - Default settings running amuck!';
}
?>

PHP INI SETTINGS:
<?php print_r(ini_get_all()); ?>

</code>
</blockquote>
<?php

include_once("step_footer.php");

?>