Maak een PHP-pagina om emails te kunnen toevoegen. Noem deze pagina email.php.

<?php
    // get login
    require_once 'login.php';
    // mysqli connection
    $conn = new mysqli($hn, $un, $pw, $db);
    if($conn->connect_error) die('Fatal error');

    // get inputs from $_POST
    // sanitize
    // write to according variable
    if(isset($_POST['email'])    &&
        isset($_POST['lidnr'])) {
            $lidnr = sanitizeString($_POST['lidnr']);
            $email = sanitizeString($_POST['email']);
        }

        // prepare stmt
        $stmt = $conn->prepare("INSERT INTO email (email, lidnummer) VALUES(?,?)");
        // bind params
        $stmt->bind_param('ss', $email, $lidnr);
        // execute stmt
        $stmt->execute();
        // close conn and stmt
        $stmt->close();
        $conn->close();


    // echo form to add postcode
    echo <<<_END
    <form action="email.php" method="post"><pre>
        Email    <input type="text" name="email">
        Lidnr    <input type="text" name="lidnr">
                 <input type="submit" value="Email toevoegen">
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