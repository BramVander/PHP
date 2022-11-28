<?php
require_once 'login.php';
// mysqli connection
$conn = new mysqli($hn, $un, $pw, $db);
if($conn->connect_error) die('Fatal error');

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

// we echo html to add team
echo <<<_END
<form action="" method="post" style="padding: 30px; background-color: cornflowerblue;"><pre>
    Teamnaam        <input type="text" name="teamnaam" required>
    Omschrijving    <input type="text" name="omschrijving" required>
                    <input type="submit" value="Nieuw team toevoegen">
</pre></form>
_END;

// we echo html to add teammembers
echo <<<_END
<form action="" method="post" style="padding: 30px; background-color: cornflowerblue;"><pre>
    Teamnaam        <select name="teamnaam" id="teamnaam" required>
_END;

// set up query for teamnaam dropdown
$query = "SELECT * FROM teams";
$result = $conn->query($query);
if(!$result) die('lidnr query failed');

$teamRows = $result->num_rows;

for($i = 0; $i < $teamRows; ++$i) {
    $teamRow = $result->fetch_array(MYSQLI_NUM);
    // lidnr column is at lidnrRow[0]
    $teamnaam = htmlspecialchars($teamRow[0]);
    // we echo the result inside of the loop
    echo <<<_END
    <option value="$teamnaam">$teamnaam</option>
    _END;
}

echo <<<_END
</select><br>
_END;

echo <<<_END
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
                    <input type="submit" value="Lid toevoegen aan team">
                    <input type="hidden" name="addtoteam" value="yes">
</form>
</pre>
</body>
</html>
_END;

if(isset($_POST['teamnaam']) &&
   isset($_POST['omschrijving'])) {
    $teamnaam = sanitizeString($_POST['teamnaam']);
    $omschrijving =sanitizeString($_POST['omschrijving']);

    // prepare stmt
    $stmt = $conn->prepare("INSERT INTO teams VALUES(?,?)");
    // bind params
    $stmt->bind_param('ss', $teamnaam, $omschrijving);
    // execute stmt
    $stmt->execute();
    // close conn and stmt
    $stmt->close();
    $conn->close();
}

if(isset($_POST['addtoteam']) &&
   isset($_POST['lidnummer']) &&
   isset($_POST['teamnaam'])) {
    $teamnaam = sanitizeString($_POST['teamnaam']);
    $lidnr =sanitizeString($_POST['lidnummer']);

    // prepare stmt
    $stmt = $conn->prepare("INSERT INTO teamlid (teamnaam, lidnummer) VALUES(?,?)");
    // bind params
    $stmt->bind_param('ss', $teamnaam, $lidnr);
    // execute stmt
    $stmt->execute();
    // close conn and stmt
    $stmt->close();
    $conn->close();
}

function sanitizeString($string) {
    if(get_magic_quotes_gpc())
        $string = stripslashes($string);
    $string = strip_tags($string);
    $string = htmlentities($string);
    return $string;
}