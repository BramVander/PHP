<?php 
class Mens {
    public $name, $length, $weight;

    function __construct($name, $length, $weight) {
        $this->name = $name;
        $this->length = $length;
        $this->weight = $weight;
    }

    function bmi() {
        $bmi = $this->weight / ($this->length * $this->length);
        echo `bmi is ` . round($bmi);
    }
}

$personOne = new Mens('Bram', 1.80, 70);
$personTwo = new Mens('Pan', 1.60, 60);
$personThree = new Mens('Nyx', 1.65, 75);

$personOne->bmi();
echo '<br>';
$personTwo->bmi();
echo '<br>';
$personThree->bmi();
?>