<?php
$tables = array(
    '1' => array(),
    '2' => array(),
    '3' => array(),
    '4' => array(),
    '5' => array(),
    '6' => array(),
    '7' => array(),
    '8' => array(),
    '9' => array(),
    '10' => array()
);

for($i=1; $i < 11; $i++) { // <11 being count($tables) +1
    for($j = 1; $j < 11; $j++) {
        array_push($tables[$i], $i * $j);
    }
}

echo "<pre>";
print_r($tables);
?>