<?php
require_once 'login.php';
// mysqli connection
$conn = new mysqli($hn, $un, $pw, $db);
if($conn->connect_error) die('Fatal error');

if(isset($_COOKIE['un']) &&
   isset($_COOKIE['pw'])) {
    echo <<<_END
    <html>
    <head>
      <title>Vereniging</title>
    </head>
    <body>
      <pre>
        <div style="color: white; background-color: grey; display: flex; justify-content: center; padding: 30px; font-size: 30px;">
          <b>Welkom bij de ledenlijst van onze vereniging</b>
        </div>
        <nav style="display: flex; justify-content: space-evenly; margin-bottom: 50px;">
          <a style="background-color: greenyellow; color: black; box-shadow: 5px 10px 8px #888888; text-decoration: none; border-radius: 5px; padding: 15px;" href="home.php">Home</a>
          <a style="background-color: greenyellow; color: black; box-shadow: 5px 10px 8px #888888; text-decoration: none; border-radius: 5px; padding: 15px;" href="ledenlijst.php">Ledenlijst</a>
          <a style="background-color: greenyellow; color: black; box-shadow: 5px 10px 8px #888888; text-decoration: none; border-radius: 5px; padding: 15px;" href="/feedback/eindopdracht/wijzigen.php">Lid wijzigen</a>
          <a style="background-color: greenyellow; color: black; box-shadow: 5px 10px 8px #888888; text-decoration: none; border-radius: 5px; padding: 15px;" href="/feedback/eindopdracht/postcode.php">Postcodes toevoegen</a>
          <a style="background-color: greenyellow; color: black; box-shadow: 5px 10px 8px #888888; text-decoration: none; border-radius: 5px; padding: 15px;" href="/feedback/eindopdracht/email.php">Email toevoegen</a>
          <a style="background-color: greenyellow; color: black; box-shadow: 5px 10px 8px #888888; text-decoration: none; border-radius: 5px; padding: 15px;" href="/feedback/eindopdracht/telefoon.php">Telefoon toevoegen</a>
          <a style="background-color: greenyellow; color: black; box-shadow: 5px 10px 8px #888888; text-decoration: none; border-radius: 5px; padding: 15px;" href="/feedback/eindopdracht/teams.php">Team samenstellen</a>
          <a style="background-color: greenyellow; color: black; box-shadow: 5px 10px 8px #888888; text-decoration: none; border-radius: 5px; padding: 15px;" href="remove.php">Teamleden verwijderen</a>
        </nav>
    _END;

    echo <<<_END
    <form action="" method="post" style="padding: 30px;"><pre>
    Lidnummer       <select name="lidnummer" id="lidnummer" required>
    _END;

    // set up query for lidnr dropdown
    $query = "SELECT * FROM leden";
    $result = $conn->query($query);
    if(!$result) die('lidnr query failed');

    $lidnrRows = $result->num_rows;

    for($i = 0; $i < $lidnrRows; ++$i) {
        $lidnrRow = $result->fetch_array(MYSQLI_NUM);
        // lidnr column is at lidnrRow[0]
        $lidnr = htmlspecialchars($lidnrRow[0]);
        $voornaam = htmlspecialchars($lidnrRow[1]);
        $achternaam = htmlspecialchars($lidnrRow[2]);
        // we echo the result inside of the loop
        echo <<<_END
        <option value="$lidnr">#$lidnr $voornaam $achternaam</option>
        _END;
    }

    // outside the loop we continue with echoing the HTML
    echo <<<_END
    </select>
    <br>
      <label>Voornaam
        <input name="voornaam" type="text" required>
      </label>
      <label>Achternaam
        <input name="achternaam" type="text" required>
      </label>
      <label>Postcode
        <input name="postcode" type="text" required>
      </label>
      <label>Huisnummer
        <input name="huisnummer" type="text" required>
      </label>

      <input type="submit" value="Lid aanpassen">
      </form>
    _END;    
} else {
  header("Location: home.php");
}

if(isset($_POST['lidnummer'])  &&
   isset($_POST['voornaam'])   &&
   isset($_POST['achternaam']) &&
   isset($_POST['postcode'])   &&
   isset($_POST['huisnummer'])) {
    $lidnummer = sanitizeString($_POST['lidnummer']);
    $voornaam = sanitizeString($_POST['voornaam']);
    $achternaam = sanitizeString($_POST['achternaam']);
    $postcode = sanitizeString($_POST['postcode']);
    $huisnummer = sanitizeString($_POST['huisnummer']);

    $query = "UPDATE leden SET voornaam='$voornaam', achternaam='$achternaam', huisnummer='$huisnummer' WHERE lidnummer='$lidnummer'";
    $conn->query($query);
    echo 'succesfully edited';
}

function sanitizeString($string) {
if(get_magic_quotes_gpc())
    $string = stripslashes($string);
$string = strip_tags($string);
$string = htmlentities($string);
return $string;
}