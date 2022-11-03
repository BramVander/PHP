Maak een PHP-pagina ledenlijst.php waar een join wordt gemaakt tussen alle tabellen op basis van het lidnummer en postcode. Ga ervan uit dat elk lid één telefoonnummer en één e-mailadres heeft.

<?php
    // get login
    require_once 'login.php';
    $mysqli = new mysqli($hn, $un, $pw, $db);
    if(mysqli_connect_errno()) die('Fatal error');

    $link = mysqli_connect($hn, $un, $pw, $db);
    if(mysqli_connect_errno()) die('Fatal error');

    // concat queries for multi query
    // $query = "SELECT * FROM leden NATURAL JOIN postcode";
    // $query .= "SELECT * FROM email NATURAL JOIN leden";
    // $query .= "SELECT * FROM telefoon NATURAL JOIN leden";

    // query
    $result = mysqli_query($link, "SELECT leden.lidnummer, naam, leden.postcode, huisnummer, email, telefoonnummer, adres, woonplaats FROM leden INNER JOIN postcode ON leden.postcode = postcode.postcode INNER JOIN email ON leden.lidnummer = email.lidnummer INNER JOIN telefoon ON leden.lidnummer = telefoon.lidnummer");

    // result contains 3 rows, 8 fields as expected
    echo "<pre>";
    print_r($result);
    echo "</pre>";

    $rows = mysqli_num_rows($result);
    // $row = mysqli_fetch_array($result, MYSQLI_NUM);

    // for multiple rows we loop through each row and echo the fielddata
    for($j = 0; $j < $rows; ++$j) {
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

        echo '<pre>';
        echo 'Lidnummer: ' . $row['lidnummer'] . '<br>';
        echo 'Naam: ' . $row['naam'] . '<br>';
        echo 'Postcode: ' . $row['postcode'] . '<br>';
        echo 'Huisnummer: ' . $row['huisnummer'] . '<br>';
        echo 'Adres: ' . $row['adres'] . '<br>';
        echo 'Email: ' . $row['email'] . '<br>';
        echo 'Telefoon: ' . $row['telefoonnummer'] . '<br>';
        echo 'Woonplaats: ' . $row['woonplaats'] . '<br>';
        echo '</pre>';

    }
    
?>