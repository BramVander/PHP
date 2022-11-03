Maak een PHP-pagina (schoon.php) die alle leden uit de database verwijderd, maar de postcodes laat staan.

<?php
    // get login
    require_once 'login.php';
    // procedural connection
    $link = mysqli_connect($hn, $un, $pw, $db);
    if(mysqli_connect_errno()) die('Fatal error');

    // echo form to delete * but postcode
    echo <<<_END
    <form action="schoon.php" method="post"><pre>
        <input type='hidden' name='delete' value='yes'>
        <input type="submit" value="Verwijder leden">
    </pre></form>
    _END;

    // check if delete btn is pressed send query to delete all records in leden table
    if (isset($_POST['delete'])) {
        // prepare query
        mysqli_query($link, "DELETE FROM leden");
    }
?>