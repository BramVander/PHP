Maak een PHP-pagina om postcodes te kunnen toevoegen. Noem deze pagina postcode.php.

<?php
    // get login
    require_once 'login.php';
    // mysqli connection
    // $conn = new mysqli($hn, $un, $pw, $db);
    // if($conn->connect_error) die("fatal error");
    
    // procedural connection
    $link = mysqli_connect($hn, $un, $pw, $db);
    if(mysqli_connect_errno()) die('Fatal error');

    // get inputs from $_POST
    // sanitize
    // write to according variable
    if(isset($_POST['postcode'])    &&
        isset($_POST['adres'])      &&
        isset($_POST['woonplaats'])) {
            $postcode = mysql_entities_fix_string($link, $_POST['postcode']);
            $adres = mysql_entities_fix_string($link, $_POST['adres']);
            $woonplaats = mysql_entities_fix_string($link, $_POST['woonplaats']);
        }

    // prepare statement
    $stmt = mysqli_prepare($link, 'INSERT INTO postcode VALUES(?,?,?)');
    // bind statement params
    mysqli_stmt_bind_param($stmt, 'sss', $postcode, $adres, $woonplaats);
    // execute statement
    mysqli_stmt_execute($stmt);
    // close statement
    mysqli_stmt_close($stmt);
    // close mysql connection
    mysqli_close($link);


    // echo form to add postcode
    echo <<<_END
    <form action="postcode.php" method="post"><pre>
        Postcode    <input type="text" name="postcode">
        Adres       <input type="text" name="adres">
        Woonplaats  <input type="text" name="woonplaats">
                    <input type="submit" value="Postcode toevoegen">
    </pre></form>
    _END;

    // sanitize functions
    function mysql_entities_fix_string($conn, $string)
    {
      return htmlentities(mysql_fix_string($conn, $string));
    }    
  
    function mysql_fix_string($conn, $string)
    {
      if (get_magic_quotes_gpc()) $string = stripslashes($string);
      return $conn->real_escape_string($string);
    }
?>