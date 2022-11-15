Maak een PHP-pagina om telefoons te kunnen toevoegen. Noem deze pagina telefoon.php.

<?php
    // get login
    require_once 'login.php';
    // mysqli connection
    $conn = new mysqli($hn, $un, $pw, $db);
    if($conn->connect_error) die('Fatal error');

    // get inputs from $_POST
    // sanitize
    // write to according variable
    if (isset($_POST['telefoon'])    &&
        isset($_POST['lidnr'])) {
            $lidnr = sanitizeString($_POST['lidnr']);
            $telefoonnr = sanitizeString($_POST['telefoon']);
        }

        // prepare stmt
        $stmt = $conn->prepare("INSERT INTO telefoon (telefoonnummer, lidnummer) VALUES(?,?)");
        // bind params
        $stmt->bind_param('ss', $telefoonnr, $lidnr);
        // execute stmt
        $stmt->execute();
        // close conn and stmt
        $stmt->close();
        $conn->close();


    // echo form to add postcode
    echo <<<_END
    <form action="telefoon.php" method="post"><pre>
        Telefoon <input type="text" name="telefoon">
        Lidnr    <input type="text" name="lidnr">
                 <input type="submit" value="Telefoonnummer toevoegen">
    </pre></form>
    _END;

    function sanitizeString($string) {
        if(get_magic_quotes_gpc())
            $string = stripslashes($string);
        $string = strip_tags($string);
        $string = htmlentities($string);
        return $string;
    }
?>