<?php 
class Circel {
    public $diameter;

    function __construct($name, $diameter) {
        $this->diameter = $diameter;
        $this->name = $name;
    }

    function oppervlakteCircel() {
        // pi * straal * straal
        $straal = $this->diameter / 2;
        $opp = $straal * $straal * pi();
        $result = 'de oppervlakte in cm2 van ' . $this->name . ' is ongeveer ' . round($opp);
        echo $result;
    }

    function omtrekCircel() {
        // diameter * pi
        $omtr = $this->diameter * pi();
        $result = 'de omtrek in cm van ' . $this->name . ' is ongeveer ' . round($omtr);
        echo $result;
    }
}

$voetbal = new Circel('voetbal', 100);
$bloempot = new Circel('bloempot', 25);
$stuur = new Circel('stuur', 75);

$voetbal->omtrekCircel();
echo '<br>';
$voetbal->oppervlakteCircel();
echo '<br>';
echo '<br>';
$bloempot->omtrekCircel();
echo '<br>';
$bloempot->oppervlakteCircel();
echo '<br>';
echo '<br>';
$stuur->omtrekCircel();
echo '<br>';
$stuur->oppervlakteCircel();
?>