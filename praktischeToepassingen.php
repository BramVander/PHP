<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
    </head>
    <body>
        <h1>Persoonlijke gegevens:</h1>
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="form">
            <label for="naam">Voor & achternaam: </label>
            <input type="text" name="naam" placeholder="Uw voor- en achternaam">
            <br>
            <label for="adres">Straat en huisnummer: </label>
            <input type="text" name="adres" placeholder="Uw straat en huisnummer">
            <br>
            <label for="zip">Uw postcode: </label>
            <input type="text" name="zip" placeholder="vb: 1234 AB">
            <br>
            <label for="woonplaats">Woonplaats: </label>
            <input type="text" name="woonplaats" placeholder="uw woonplaats">
            <br>
            <label for="telnr">Telefoon nummer: </label>
            <input type="text" name="telnr" placeholder="tel-nr">
            <br>
            <label for="email">Email: </label>
            <input type="text" name="email" placeholder="email@adres.com">
            <br>
            <br>
            <input type="submit">
        </form>
    </body>
</html>

<?php

function sanitize_input($input) {
    $input = trim($input);
    $input = stripslashes($input);
    $input = htmlspecialchars($input);
    return $input;
}

// create error variables
$naamError = $adresError = $zipError = $woonplaatsError = $telnrError = $emailError = "";
// create input variables
$naam = $adres = $zip = $woonplaats = $telnr = $email = "";
// create input array
$forminput = Array();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["naam"])) {
      $naamError = "naam is verplicht";
    } else {
      $naam = sanitize_input($_POST["naam"]);
      array_push($forminput, $naam);
      // check if name only contains letters and whitespace
      if (!preg_match("/^[a-zA-Z-' ]*$/",$naam)) {
        $naamError = "Alleen letters en spaties";
      }
    }

    if (empty($_POST["adres"])) {
        $adresError = "adres is verplicht";
      } else {
        $adres = sanitize_input($_POST["adres"]);
        array_push($forminput, $adres);
        // check if name only contains letters and whitespace
        if (!preg_match("/^[a-zA-Z-' ]*$/",$adres)) {
          $adresError = "Geen geldig adres";
        }
      }

      if (empty($_POST["zip"])) {
        $zipError = "zip is verplicht";
      } else {
        $zip = sanitize_input($_POST["zip"]);
        array_push($forminput, $zip);
        // check if name only contains letters and whitespace
        if (!preg_match("/^[a-zA-Z-' ]*$/",$zip)) {
          $zipError = "geen geldige zip";
        }
      }

      if (empty($_POST["woonplaats"])) {
        $woonplaatsError = "woonplaats is verplicht";
      } else {
          $woonplaats = sanitize_input($_POST["woonplaats"]);
          array_push($forminput, $woonplaats);
          // check if name only contains letters and whitespace
        if (!preg_match("/^[a-zA-Z-' ]*$/",$woonplaats)) {
          $woonplaatsError = "geen geldige woonplaats";
        }
      }

      if (empty($_POST["telnr"])) {
        $telnrError = "telnr is verplicht";
      } else {
        $telnr = sanitize_input($_POST["telnr"]);
        array_push($forminput, $telnr);
        // check if name only contains letters and whitespace
        if (!preg_match("/^[a-zA-Z-' ]*$/",$telnr)) {
          $telnrError = "geen geldig telnr";
        }
      }

      if (empty($_POST["email"])) {
        $emailError = "email is verplicht";
      } else {
        $email = sanitize_input($_POST["email"]);
        array_push($forminput, $email);
        // check if name only contains letters and whitespace
        if (!preg_match("/^[a-zA-Z-' ]*$/",$email)) {
          $emailError = "geen geldig email";
        }
      }
}

echo '<br> test <br>';
print_r($_POST);
echo '<br> endtest <br>';

echo "<br> forminput <br>";
print_r($forminput);
echo "<br> /forminput <br>";

$text = 'naam: ' . $naam . "\n" . 'adres: ' . $adres . "\n" . 'woonplaats: ' . $woonplaats . "\n" . 'zip: ' . $zip . "\n" . 'telnr: ' . $telnr . "\n" . 'email: ' . $email;

// $fh = fopen("user.txt", 'w') or die('failed creation');
// fwrite($fh, $text) or die('failed writing');
// fclose($fh);


// echo "<pre>";
// echo file_get_contents("user.txt");
// echo "</pre>";
?>

<style>
    .form {
        display: flex;
        flex-direction: column;
    }
</style>