Maak een PHP-pagina ledenlijst.php waar een join wordt gemaakt tussen alle tabellen op basis van het lidnummer en postcode. Ga ervan uit dat elk lid één telefoonnummer en één e-mailadres heeft.

<?php
    // get login
    require_once 'login.php';
    $link = mysqli_connect($hn, $un, $pw, $db);
    if(mysqli_connect_errno()) die('Fatal error');

    // query
    $result = mysqli_query($link, "SELECT leden.lidnummer, naam, leden.postcode, huisnummer, email, telefoonnummer, adres, woonplaats FROM leden INNER JOIN postcode ON leden.postcode = postcode.postcode INNER JOIN email ON leden.lidnummer = email.lidnummer INNER JOIN telefoon ON leden.lidnummer = telefoon.lidnummer");

    $rows = mysqli_num_rows($result);

    // for multiple rows we loop through each row and echo the fielddata
    for($j = 0; $j < $rows; ++$j) {
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

        echo <<<_END
        <pre>
        <form method="post" action="">
            Lidnaam: $row[lidnummer]
            Naam: $row[naam]
            Postcode: $row[postcode]
            Huisnummer: $row[huisnummer]
            Adres: $row[adres]
            Email: $row[email]
            Telefoon: $row[telefoonnummer]
            Woonplaats: $row[woonplaats]
        </form>
        </pre>
        _END;
    }
    
?>