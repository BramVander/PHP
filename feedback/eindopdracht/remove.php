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
      <nav style="display: flex; justify-content: space-evenly; margin-bottom: 30px;">
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

$teamnamen = [];
$lorem = [];
$pokemon = [];
$zelda = [];

$query = "SELECT teamnaam FROM teams";
$result = $conn->query($query);
if(!$result) die('lidnr query failed');

$rows = $result->num_rows;
for($i = 0; $i < $rows; ++$i) {
    $teamnaam = $result->fetch_array(MYSQLI_NUM);
    array_push($teamnamen, $teamnaam);
}

// tried fixing in loop
// loop worked for lorem
// loop added lorem members to pokemon members as well
// loop added lorem members and pokemon members to zelda as well
// it adds previous results ??

// fetch members ids loremIpsum
$query = "SELECT lidnummer FROM teamlid WHERE teamnaam='LoremIpsum'";
$result = $conn->query($query);
if(!$result) die('fatal error teamnaam[0]');
$rows = $result->num_rows;
for($i = 0; $i < $rows; ++$i) {
    $lidnr = $result->fetch_array(MYSQLI_NUM);
    array_push($lorem, $lidnr);
}

// fetch members pokemon
$query = "SELECT lidnummer FROM teamlid WHERE teamnaam='Pokemon'";
$result = $conn->query($query);
if(!$result) die('fatal error teamnaam[0]');
$rows = $result->num_rows;
for($i = 0; $i < $rows; ++$i) {
    $lidnr = $result->fetch_array(MYSQLI_NUM);
    array_push($pokemon, $lidnr);
}

// fetch member ids zelda
$query = "SELECT lidnummer FROM teamlid WHERE teamnaam='Zelda'";
$result = $conn->query($query);
if(!$result) die('fatal error teamnaam[0]');
$rows = $result->num_rows;
for($i = 0; $i < $rows; ++$i) {
    $lidnr = $result->fetch_array(MYSQLI_NUM);
    array_push($zelda, $lidnr);
}

echo '<br>';
echo '<h1>LoremIpsum team</h1>';

// fetch names for lorem
foreach($lorem as $lid) {
    $query = "SELECT voornaam, achternaam FROM leden WHERE lidnummer='$lid[0]'";
    $result = $conn->query($query);
    if(!$result) die('lorem error');
    $rows = $result->num_rows;
    for($i = 0; $i < $rows; ++$i) {
        $naam = $result->fetch_array(MYSQLI_NUM);
        echo $lid[0] . ' ' . sanitizeString($naam[0]) . ' ' .  sanitizeString($naam[1]) . '<br>';
        echo <<<_END
        <form method="post" action="">
        <input type="submit" value="VERWIJDER LID VAN TEAM" style="background-color: indianred; color: white; border: none; border-radius: 5px; padding: 10px; cursor: pointer;">
        <input type="hidden" name="deletefromteam" value=$lidnr[0]>
        </form>
        _END;
    }
}

echo '<br>';
echo '<h1>Pokemon team</h1>';

// fetch names for pokemon
foreach($pokemon as $lid) {
    $query = "SELECT voornaam, achternaam FROM leden WHERE lidnummer='$lid[0]'";
    $result = $conn->query($query);
    if(!$result) die('lorem error');
    $rows = $result->num_rows;
    for($i = 0; $i < $rows; ++$i) {
        $naam = $result->fetch_array(MYSQLI_NUM);
        echo $lid[0] . ' ' . sanitizeString($naam[0]) . ' ' .  sanitizeString($naam[1]) . '<br>';
        echo <<<_END
        <form method="post" action="">
        <input type="submit" value="VERWIJDER LID VAN TEAM" style="background-color: indianred; color: white; border: none; border-radius: 5px; padding: 10px; cursor: pointer;">
        <input type="hidden" name="deletefromteam" value=$lidnr[0]>
        </form>
        _END;
    }
}

echo '<br>';
echo '<h1>Zelda team</h1>';

// fetch names for zelda
foreach($zelda as $lid) {
    $query = "SELECT voornaam, achternaam FROM leden WHERE lidnummer='$lid[0]'";
    $result = $conn->query($query);
    if(!$result) die('lorem error');
    $rows = $result->num_rows;
    for($i = 0; $i < $rows; ++$i) {
        $naam = $result->fetch_array(MYSQLI_NUM);
        echo $lid[0] . ' ' . sanitizeString($naam[0]) . ' ' .  sanitizeString($naam[1]) . '<br>';
        echo <<<_END
        <form method="post" action="">
        <input type="submit" value="VERWIJDER LID VAN TEAM" style="background-color: indianred; color: white; border: none; border-radius: 5px; padding: 10px; cursor: pointer;">
        <input type="hidden" name="deletefromteam" value=$lidnr[0]>
        </form>
        _END;
    }
}

// delete from team
if(isset($_POST['deletefromteam'])) {
    $query = "DELETE FROM teamlid WHERE lidnummer='$lidnr[0]'";
    $result = $conn->query($query);
    if(!$result) die('delete query fail');
    echo 'removed succesfully';
}

function sanitizeString($string) {
    if(get_magic_quotes_gpc())
        $string = stripslashes($string);
    $string = strip_tags($string);
    $string = htmlentities($string);
    return $string;
}