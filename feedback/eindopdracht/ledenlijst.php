<?php
require_once 'login.php';
// set up connection
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
      </nav>
_END;

// set up query to show all members
$query = "SELECT * FROM leden";
$result = $conn->query($query);
if(!$result) die('query failed');

$rows = $result->num_rows;

// we echo html to add members
echo<<<_END
<h1>LID TOEVOEGEN</h1>
<form method="post" action="" style="display: flex; flex-direction: column; background-color: gold; padding: 10px; padding-bottom: 30px; width: 300px;">
                <input type="hidden" name="submitted" value="yes">
voornaam        <input type="text" name="voornaam" required>
achternaam      <input type="text" name="achternaam" required>
huisnummer      <input type="text" name="huisnummer" required>
postcode        <select name="postcode" id="postcode" required>
_END;

// set up query to show all postcodes
$zipQuery = "SELECT * FROM postcode";
$zipResult = $conn->query($zipQuery);
if(!$zipResult) die('zipQuery failed');

$zipRows = $zipResult->num_rows;

for($i = 0; $i < $zipRows; ++$i) {
$zipRow = $zipResult->fetch_array(MYSQLI_NUM);
// postcode column is at zipRow[0]
$zip = htmlspecialchars($zipRow[0]);
// we echo the result inside of the loop
echo <<<_END
<option value="$zip">$zip</option>
_END;
}

// outside the loop we continue with echoing the HTML
echo <<<_END
</select><br>
                  <input type="submit" value="Lid toevoegen">
</form>
</pre>
</body>
</html>
_END;

echo <<<_END
<h1>LEDENLIJST</h1>
<div style="display: flex; flex-direction: row; gap: 20px; flex-wrap: wrap;">
_END;

if(isset($_POST['voornaam'])   &&
   isset($_POST['achternaam']) &&
   isset($_POST['huisnummer'])) {
    $voornaam   = mysql_entities_fix_string($conn, $_POST['voornaam']);
    $achternaam = mysql_entities_fix_string($conn, $_POST['achternaam']);
    $huisnummer = mysql_entities_fix_string($conn, $_POST['huisnummer']);
    $postcode   = mysql_entities_fix_string($conn, $_POST['postcode']);
  }
  // prepare stmt
  $stmt = $conn->prepare("INSERT INTO leden (voornaam, achternaam, postcode, huisnummer) VALUES(?,?,?,?)");
  // bind params
  $stmt->bind_param('ssss', $voornaam, $achternaam, $postcode, $huisnummer);
  // execute stmt
  $stmt->execute();
  // close conn and stmt
  $stmt->close();
  $conn->close();

// loop through results to display members
for($i = 0; $i < $rows; ++$i) {
    // assign records from result to row
    $row = $result->fetch_array(MYSQLI_NUM);
    // lidnummer column is at row[0]
    $r0 = htmlspecialchars($row[0]);
    // voornaam column is at row[1]
    $r1 = htmlspecialchars($row[1]);
    // achternaam column is at row[2]
    $r2 = htmlspecialchars($row[2]);
    // postcode column is at row[3]
    $r3 = htmlspecialchars($row[3]);
    // huisnummer column is at row[4]
    $r4 = htmlspecialchars($row[4]);

    echo <<<_END
    <pre style="background-color: lavender; width: 325px;">
    <form method="post" action="">
      Lidnummer:    $r0
      Voornaam:     $r1
      Achternaam:   $r2
      Postcode:     $r3
      Huisnummer:   $r4
      <input type='hidden' name='delete' value=$r0>
      <input type="submit" value="VERWIJDER LID" style="color: white; background-color: indianred; border: none; border-radius: 5px; padding: 15px; cursor: pointer;">
    </form></pre>
    _END;
}

if(isset($_POST['delete'])) {
  $lidnr = mysql_entities_fix_string($conn, $_POST['delete']);
  
  // reopen connection after $conn->close();
  $conn = new mysqli($hn, $un, $pw, $db);
  if($conn->connect_error) die('Fatal error');
  
  $query = "DELETE FROM leden WHERE lidnummer=$lidnr";
  $result = $conn->query($query);
  if(!$result) die('delete query failed');
}

// sanitize functions
function mysql_entities_fix_string($conn, $string)
{
  // after a $conn->close() we need to reopen connection
  // this function doesnt seem to have acces so we reconnect manually
  $hn = 'localhost';
  $db = 'vereniging';
  $un = 'vander';
  $pw = 'mysql';
  $conn = new mysqli($hn, $un, $pw, $db);
  if($conn->connect_error) die('Fatal error');

  return htmlentities(mysql_fix_string($conn, $string));
}    

function mysql_fix_string($conn, $string)
{
  // after a $conn->close() we need to reopen connection
  // this function doesnt seem to have acces so we reconnect manually
  $hn = 'localhost';
  $db = 'vereniging';
  $un = 'vander';
  $pw = 'mysql';
  $conn = new mysqli($hn, $un, $pw, $db);
  if($conn->connect_error) die('Fatal error');

  if (get_magic_quotes_gpc()) $string = stripslashes($string);
  return $conn->real_escape_string($string);
}