<?php

include_once("step_header.php");

?>
<h3>Test 5 - Reflection Tests</h3>
<blockquote>
<code>
<!-- Reflection Testing -->
Reflection Test: <?php

class A
{
    public $one = '';
    public $two = '';
    public $three = '';
   
    //Constructor
    public function __construct()
    {
        //Constructor
    }
   
    //print variable one
    public function echoOne()
    {
        echo $this->one."";
    }

    //print variable two   
    public function echoTwo()
    {
        echo $this->two."";
    }

    //print variable three  
    public function echoThree()
    {
        echo $this->three."";
    }
}

//Instantiate the object
$a = new A();

if (class_exists("ReflectionClass")) {
//Instantiate the reflection object
$reflector = new ReflectionClass('A');

//Now get all the properties from class A in to $properties array
$properties = $reflector->getProperties();

$i =1;
//Now go through the $properties array and populate each property
foreach($properties as $property)
{
    //Populating properties
    $a->{$property->getName()}=$i;
    //Invoking the method to print what was populated
    $a->{"echo".ucfirst($property->getName())}()."";
   
    $i++;
}
echo " ok";
} else {
echo " failed (PHP is missing reflection extension.)";
}
?>

</code>
</blockquote>
<?php

include_once("step_footer.php");

?>