<?php
// get login
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

        <form action="" method="post" style="padding: 30px; background-color: cornflowerblue;"><pre>
        Selecteer van welk lid je de telefoon gegevens wil wijzigen:<br>
        <select name="edit" id="edit" required>
_END;

// set up query for leden dropdown
$query = "SELECT * FROM leden";
$result = $conn->query($query);
if(!$result) die('lidnr query failed');
$lidnrRows = $result->num_rows;
for($i = 0; $i < $lidnrRows; ++$i) {
$lidnrRow = $result->fetch_array(MYSQLI_NUM);
// lidnr column is at lidnrRow[0]
$lidnr = htmlspecialchars($lidnrRow[0]);
// voornaam column is at lidnrRow[1]
$voornaam = htmlspecialchars($lidnrRow[1]);
// achternaam column is at lidnrRow[0]
$achternaam = htmlspecialchars($lidnrRow[2]);

// we echo the result inside of the loop
echo <<<_END
    <option value="$lidnr">#$lidnr $voornaam $achternaam</option>
_END;
}

// we echo rest of form
echo <<<_END
  </select>
        <input type="submit" value="Bekijk telefoon gegevens">
  </form>
  </pre>
  </body>
  </html>
_END;

// check for chosen lid, save lidnr
if(isset($_POST['edit'])) {
    $updateLidnr = sanitizeString($_POST['edit']);

    $conn = new mysqli($hn, $un, $pw, $db);
    $query = "SELECT * FROM telefoon WHERE lidnummer='$updateLidnr'";
    if($conn->connect_error) die('Fatal error');

    $result = $conn->query($query);
    if(!$result) die('lidnr query failed');
    $rows = $result->num_rows;
    for($i = 0; $i < $rows; ++$i) {
       $data = $result->fetch_array(MYSQLI_NUM);
       $telefoon = htmlspecialchars($data[0]);
       echo <<<_END

       <form method="post" action=''>
        <input value="$telefoon">
        <input type="hidden" name="delete" value=$telefoon>
        <input type="submit" value="verwijderen" style="background-color: red; border: none; padding: 5px; cursor: pointer;">
       </form>
       _END;
    }
    
    // form for adding new email
    echo <<<_END
    <form action='' method='post'>
    <label>Telefoon toevoegen:
    <input name='addPhone'>
    <input type='hidden' name='updateLid' value='$updateLidnr'>
    </label>
    <input type='submit' value='Telefoon toevoegen'>
    </form>
    _END;
}

// check for adding email
if(isset($_POST['addPhone'])) {
    $newPhone = sanitizeString($_POST['addPhone']);
    $updateLid = sanitizeString($_POST['updateLid']);

    $conn = new mysqli($hn, $un, $pw, $db);
    if($conn->connect_error) die('Fatal error');
    $query = "INSERT INTO telefoon(telefoonnummer, lidnummer) VALUES('$newPhone', '$updateLid')";
    $result = $conn->query($query);
    if(!$result) die('add phone query fail');
    echo 'added succesfully';
    // prevent refresh data insertion
    unset($_POST);
}

// check for submit on delete email
if(isset($_POST['delete'])) {
    $phone = sanitizeString($_POST['delete']);

    $conn = new mysqli($hn, $un, $pw, $db);
    if($conn->connect_error) die('Fatal error');
    $query = "DELETE FROM telefoon WHERE telefoonnummer='$phone'";
    $result = $conn->query($query);
    if(!$result) die('delete query fail');
    echo 'removed succesfully';
    // prevent refresh data insertion
    unset($_POST);
}

function sanitizeString($string) {
  if(get_magic_quotes_gpc())
      $string = stripslashes($string);
  $string = strip_tags($string);
  $string = htmlentities($string);
  return $string;
}
?>