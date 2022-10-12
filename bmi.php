<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <input type="text" name="lengte" placeholder="Uw lengte in cm">
    <input type="text" name="gewicht" placeholder="Uw gewicht in kg">
    <input type="submit" name="submit" value="bereken bmi">
</form>

<?php
if(isset($_POST['submit'])) {
    $lengte = $_POST['lengte'];
    $gewicht = $_POST['gewicht'];
    $bmi = 10000*($gewicht / ($lengte * $lengte));

    switch ($bmi) {
        case $bmi<=18.5:
            echo $bmi . " underweight";
            break;
        case $bmi<=24.9:
            echo "$bmi, normal";
            break;
        case $bmi<=29.9:
            echo "$bmi, overweight";
            break;
        case $bmi>= 30:
            echo "$bmi, obese";
            break;
    }
}
?>
