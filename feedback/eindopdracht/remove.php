<?php
require_once 'login.php';
// set up connection
$conn = new mysqli($hn, $un, $pw, $db);
if($conn->connect_error) die('Fatal error');

if(isset($_COOKIE['un']) &&
   isset($_COOKIE['pw'])) {

    $un_cookie = $_COOKIE['un'];
    $pw_cookie = $_COOKIE['pw'];
    $date_cookie = date( 'l Y-m-d', $_COOKIE['date']);

    echo <<<_END
    <html>
    <head>
      <title>Vereniging</title>
    </head>
    <body>
      <pre>
        <div style="color: white; background-color: grey; display: flex; justify-content: center; align-items: center; flex-direction: column; padding: 30px;">
          <b style="font-size: 30px;">Welkom bij de ledenlijst van onze vereniging</b>
          <br>
          <div class="tooltip">Show me my cookies
            <span class="tooltiptext">Username: $un_cookie<br>Secret code: $pw_cookie<br>Date: $date_cookie</span>
          </div>
        </div>
        <nav style="display: flex; justify-content: space-evenly;">
          <a style="background-color: greenyellow; color: black; box-shadow: 5px 10px 8px #888888; text-decoration: none; border-radius: 5px; padding: 15px;" href="home.php">Home</a>
          <a style="background-color: greenyellow; color: black; box-shadow: 5px 10px 8px #888888; text-decoration: none; border-radius: 5px; padding: 15px;" href="ledenlijst.php">Ledenlijst</a>
          <a style="background-color: greenyellow; color: black; box-shadow: 5px 10px 8px #888888; text-decoration: none; border-radius: 5px; padding: 15px;" href="/feedback/eindopdracht/wijzigen.php">Lid wijzigen</a>
          <a style="background-color: greenyellow; color: black; box-shadow: 5px 10px 8px #888888; text-decoration: none; border-radius: 5px; padding: 15px;" href="/feedback/eindopdracht/postcode.php">Postcodes toevoegen</a>
          <a style="background-color: greenyellow; color: black; box-shadow: 5px 10px 8px #888888; text-decoration: none; border-radius: 5px; padding: 15px;" href="/feedback/eindopdracht/email.php">Email toevoegen</a>
          <a style="background-color: greenyellow; color: black; box-shadow: 5px 10px 8px #888888; text-decoration: none; border-radius: 5px; padding: 15px;" href="/feedback/eindopdracht/telefoon.php">Telefoon toevoegen</a>
          <a style="background-color: greenyellow; color: black; box-shadow: 5px 10px 8px #888888; text-decoration: none; border-radius: 5px; padding: 15px;" href="/feedback/eindopdracht/teams.php">Team samenstellen</a>
          <a style="background-color: greenyellow; color: black; box-shadow: 5px 10px 8px #888888; text-decoration: none; border-radius: 5px; padding: 15px;" href="remove.php">Teamleden verwijderen</a>
          <a style="background-color: greenyellow; color: black; box-shadow: 5px 10px 8px #888888; text-decoration: none; border-radius: 5px; padding: 15px;" href="logout.php">logout</a>
        </nav>
    _END;

    $teamnamen = [];

    $query = "SELECT teamnaam FROM teams";
    $result = $conn->query($query);
    if(!$result) die('lidnr query failed');

    $rows = $result->num_rows;
    for($i = 0; $i < $rows; ++$i) {
        $teamnaam = $result->fetch_array(MYSQLI_NUM);
        array_push($teamnamen, $teamnaam[0]);
    }

    foreach($teamnamen as $teamnaam) {
        echo <<<_END
        <h1>$teamnaam</h1>Delete team:<form action="" method="post"><input class="deleteTeam" type="submit" name="teamToDelete" value=$teamnaam></form>
        _END;
        $lidnrs = [];
        $query = "SELECT lidnummer FROM teamlid WHERE teamnaam='$teamnaam'";
        $result = $conn->query($query);
        if(!$result) die('fatal error teamnaam[0]');
        $rows = $result->num_rows;
        for($i = 0; $i < $rows; ++$i) {
            $lidnr = $result->fetch_array(MYSQLI_NUM);
            array_push($lidnrs, $lidnr);
        }
        foreach($lidnrs as $lid) {
            $query = "SELECT voornaam, achternaam FROM leden WHERE lidnummer='$lid[0]'";
            $result = $conn->query($query);
            if(!$result) die('lorem error');
            $rows = $result->num_rows;
            for($i = 0; $i < $rows; ++$i) {
                $naam = $result->fetch_array(MYSQLI_NUM);
                echo '<br>';
                echo '<br>';
                echo '<br>';
                echo $lid[0] . ' ' . sanitizeString($naam[0]) . ' ' .  sanitizeString($naam[1]) . '<br>';
                echo <<<_END
                <form method="post" action="">
                <input type="submit" value="VERWIJDER LID VAN TEAM" style="background-color: indianred; color: white; border: none; border-radius: 5px; padding: 10px; cursor: pointer;">
                <input type="hidden" name="deletenr" value=$lid[0]>
                <input type="hidden" name="deletefromteam" value=$teamnaam>
                </form>
                _END;
            }
        }
    }   
} else {
  header("Location: home.php");
}

// delete from team
if(isset($_POST['deletefromteam'])) {
  $hn = 'localhost';
  $db = 'vereniging';
  $un = 'vander';
  $pw = 'mysql';

  $conn = new mysqli($hn, $un, $pw, $db);
  if($conn->connect_error) die('Fatal error');

    $deleteNr = $_POST['deletenr'];
    $deleteFromTeam = $_POST['deletefromteam'];
    echo 'delete nr ' . $deleteNr . '<br>';
    echo 'deletefromteam ' . $deleteFromTeam . '<br>';
    $deleteQuery = "DELETE FROM teamlid WHERE lidnummer='$deleteNr' AND teamnaam='$deleteFromTeam'";
    $deleteResult = $conn->query($deleteQuery);
    if(!$deleteResult) die('delete query fail');
    // prevent refresh data insertion
    unset($_POST);
    ?> <script>window.location.href = '/feedback/eindopdracht/remove.php';</script> <?php
    echo 'removed succesfully';
}

// delete team
if(isset($_POST['teamToDelete'])) {
  $hn = 'localhost';
  $db = 'vereniging';
  $un = 'vander';
  $pw = 'mysql';
  $conn = new mysqli($hn, $un, $pw, $db);
  if($conn->connect_error) die('Fatal error');

  $deleteTeam = $_POST['teamToDelete'];
  $deleteTeamQuery = "DELETE FROM teams WHERE teamnaam='$deleteTeam'";
  $deleteTeamResult = $conn->query($deleteTeamQuery);
  if(!$deleteTeamResult) die('delete team query fail');
  unset($_[POST]);
  ?> <script>window.location.href = '/feedback/eindopdracht/remove.php';</script> <?php
  echo 'removed succesfully';
}

function sanitizeString($string) {
    if(get_magic_quotes_gpc())
        $string = stripslashes($string);
    $string = strip_tags($string);
    $string = htmlentities($string);
    return $string;
}

?>

<style>
.tooltip {
  position: relative;
  display: inline-block;
}

.tooltip .tooltiptext {
  visibility: hidden;
  width: 200px;
  background-color: black;
  color: #fff;
  text-align: center;
  border-radius: 6px;
  padding: 5px 0;
  position: absolute;
  z-index: 1;
  top: 50%;
  left: 25%;
  margin-left: -60px;
}

.tooltip:hover .tooltiptext {
  visibility: visible;
}

.deleteTeam {
  background-color: red;
  color: white;
  border: none;
  cursor: pointer;
  border-radius: 5px;
  padding: 5px;
}
</style>