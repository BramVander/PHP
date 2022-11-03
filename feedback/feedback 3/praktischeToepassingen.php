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
            <input type="text" name="naam" placeholder="Uw voor- en achternaam" required>
            <br>
            <label for="adres">Straat en huisnummer: </label>
            <input type="text" name="adres" placeholder="Uw straat en huisnummer" required>
            <br>
            <label for="zip">Uw postcode: </label>
            <input type="text" name="zip" placeholder="vb: 1234 AB" required>
            <br>
            <label for="woonplaats">Woonplaats: </label>
            <input type="text" name="woonplaats" placeholder="uw woonplaats" required>
            <br>
            <label for="telnr">Telefoon nummer: </label>
            <input type="text" name="telnr" placeholder="tel-nr" required>
            <br>
            <label for="email">Email: </label>
            <input type="text" name="email" placeholder="email@adres.com" required>
            <br>
            <br>
            <input type="submit">
        </form>
    </body>
</html>

<?php
// function to sanitize inputs
function sanitize_input($input) {
  $input = htmlspecialchars($input);
  return $input;
}

// function to create date on submit
function makeDate() {
  $date = date('l d F Y h:i');
  return "Op $date uur de volgende persoon ingelezen \n";
}

// we initialize the file with a heading ONCE
$fhh = fopen("user.txt", 'r+') or die ('L50 failed');
// use makeDate for date in title, better to run on submit but for now we initialize like this
fwrite($fhh, makeDate());

// create input variables
$naam = $adres = $zip = $woonplaats = $telnr = $email = "";
// create input array
if($_POST) {
  $forminput = $_POST;
}
// we clean the input and map it to new array
$clean = array_map("sanitize_input", $forminput);

// we have clean inputs at this moment

// we initialize the array with key:value in one element
$oneline = Array();

// saving inputs through a loop
// if something got posted, take post element and put it in according variable with accounting for error
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty($_POST["naam"])) {
    echo "naam is verplicht ";
  } else {
    $naam = sanitize_input($_POST["naam"]);
    array_push($forminput, $naam);
  }

  if (empty($_POST["adres"])) {
    echo "adres is verplicht ";
  } else {
    $adres = sanitize_input($_POST["adres"]);
    array_push($forminput, $adres);
  }

  if (empty($_POST["zip"])) {
    echo "zip is verplicht ";
  } else {
    $zip = sanitize_input($_POST["zip"]);
    array_push($forminput, $zip);
  }
    
  if (empty($_POST["woonplaats"])) {
    echo "woonplaats is verplicht ";
  } else {
    $woonplaats = sanitize_input($_POST["woonplaats"]);
    array_push($forminput, $woonplaats);
  }

  if (empty($_POST["telnr"])) {
    echo "telnr is verplicht ";
  } else {
    $telnr = sanitize_input($_POST["telnr"]);
    array_push($forminput, $telnr);
  }

  if (empty($_POST["email"])) {
    echo "email is verplicht ";
  } else {
    $email = sanitize_input($_POST["email"]);
    array_push($forminput, $email);
  }
}


// we loop through $clean so we can display the key value pairs;
foreach($clean as $key => $value) {
  // open/create file
  $fh = fopen("user.txt", 'r+') or die('failed creation');
  // seek last line
  fseek($fh, 0, SEEK_END);
  // write last line with key: value
  fwrite($fh, "$key:$value \n") or die('failed writing');
  // close file
  fclose($fh);
  // ONLY ONE COMMAND
  // we also push key:value to the array with key:value as 1 array element
  array_push($oneline, "$key: $value");
}

// we display the complete file at once
echo "<pre>";
echo file_get_contents("user.txt");
echo "</pre>";

// check the oneline element array
echo "<pre>";
echo makeDate();
print_r($oneline);
echo "</pre>";

?>

<style>
    .form {
        display: flex;
        flex-direction: column;
    }
</style>