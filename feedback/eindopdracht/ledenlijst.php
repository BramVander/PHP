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

  // we start ledenlijst HTML
  echo <<<_END
  <h1>LEDENLIJST</h1>
  <div style="display: flex; flex-direction: row; gap: 20px; flex-wrap: wrap;">
  _END;

  // logic for adding member
  if(isset($_POST['voornaam'])   &&
      isset($_POST['achternaam']) &&
      isset($_POST['huisnummer'])) {
    $voornaam   = mysql_entities_fix_string($conn, $_POST['voornaam']);
    $achternaam = mysql_entities_fix_string($conn, $_POST['achternaam']);
    $huisnummer = mysql_entities_fix_string($conn, $_POST['huisnummer']);
    $postcode   = mysql_entities_fix_string($conn, $_POST['postcode']);
  }
  // prepare stmt for member table data
  $stmt = $conn->prepare("INSERT INTO leden (voornaam, achternaam, postcode, huisnummer) VALUES(?,?,?,?)");
  // bind params
  $stmt->bind_param('ssss', $voornaam, $achternaam, $postcode, $huisnummer);
  // execute stmt
  $stmt->execute();
  // close conn and stmt
  $stmt->close();
  $conn->close();

  if(isset($_POST['delete'])) {
    $lidnr = mysql_entities_fix_string($conn, $_POST['delete']);
    // reopen connection after $conn->close();
    $conn = new mysqli($hn, $un, $pw, $db);
    if($conn->connect_error) die('Fatal error');
    $query = "DELETE FROM leden WHERE lidnummer=$lidnr";
    $result = $conn->query($query);
    if(!$result) die('delete query failed');
  }
} else {
  header("Location: home.php");
}

// sanitize functions
function mysql_entities_fix_string($conn, $string)
{
  // after a $conn->close() we need to reopen connection
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
  $hn = 'localhost';
  $db = 'vereniging';
  $un = 'vander';
  $pw = 'mysql';
  $conn = new mysqli($hn, $un, $pw, $db);
  if($conn->connect_error) die('Fatal error');

  if (get_magic_quotes_gpc()) $string = stripslashes($string);
  return $conn->real_escape_string($string);
}

$ids = [];

$conn = new mysqli($hn, $un, $pw, $db);
if($conn->connect_error) die('Fatal error');
$query = "SELECT * FROM leden";
$result = $conn->query($query);
if(!$result) die('lidnr query failed');

$rows = $result->num_rows;
for($i = 0; $i < $rows; ++$i) {
    $id = $result->fetch_array(MYSQLI_NUM);
    array_push($ids, $id[0] . ' ' . $id[1] . ' ' . $id[2]);
}

echo '<div class="container">';
foreach($ids as $id) {
  echo "<div class='card'><b style='font-size: 20px;'>Lid $id</b>";
  echo "<br>";
  echo "<br>";

  $query = "SELECT * FROM leden WHERE lidnummer='$id'";
  $result = $conn->query($query);
  if(!$result) die('telnr query failed');
  $rows = $result->num_rows;
  echo '<b>Data: </b><br>';
  for($i = 0; $i < $rows; ++$i) {
    $data = $result->fetch_array(MYSQLI_NUM);
    echo 'postcode: ' . $data[3] . ' ' . '<br>';
    echo 'huisnummer: ' . $data[4] . ' ' . '<br>';
    echo '<br>';
  }

  $query = "SELECT telefoonnummer FROM telefoon WHERE lidnummer='$id'";
  $result = $conn->query($query);
  if(!$result) die('telnr query failed');
  $rows = $result->num_rows;
  echo '<b>Telefoon data: </b>';
  echo '<p style="font-size: 10px; color: red;">(click to delete)</p>';
  for($i = 0; $i < $rows; ++$i) {
    $telnr = $result->fetch_array(MYSQLI_NUM);
    // echo $telnr[0] . ' ' . '<button>delete</button>' . '<br>';
    echo <<<_END
    <form action='' method='post'>
      <input type='submit' name='deletePhone' value='$telnr[0]'>
    </form>
    _END;
  }
  echo '<br>';
  $query = "SELECT email FROM email WHERE lidnummer='$id'";
  $result = $conn->query($query);
  if(!$result) die('email query failed');
  $rows = $result->num_rows;
  echo '<b>Email data: </b>';
  echo '<p style="font-size: 10px; color: red;">(click to delete)</p>';
  for($i = 0; $i < $rows; ++$i) {
    $email = $result->fetch_array(MYSQLI_NUM);
    // echo $email[0] . ' ' . '<button>delete</button>' . '<br>';
    echo <<<_END
    <form action='' method='post'>
      <input type='submit' name='deleteMail' value='$email[0]'>
    </form>
    _END;
  }
  echo <<<_END
  <br>
  <form method="post" action="">
    <input type='hidden' name='delete' value=$id>
    <input type="submit" value="VERWIJDER LID" style="color: white; background-color: indianred; border: none; border-radius: 5px; padding: 15px; cursor: pointer;">
  </form>
  </div>
  _END;
}
echo '</div>';

if(isset($_POST['deleteMail'])) {
  $deleteMail = $_POST['deleteMail'];
  $conn = new mysqli($hn, $un, $pw, $db);
  if($conn->connect_error) die('Fatal error');
  $query = "DELETE FROM email WHERE email='$deleteMail'";
  $conn->query($query);
  if(!$result) die('delete mail query fail');
  // prevent refresh data insertion
  unset($_POST);
  ?> <script>window.location.href = '/feedback/eindopdracht/ledenlijst.php';</script> <?php
  echo 'removed succesfully';
}

if(isset($_POST['deletePhone'])) {
  $deletePhone = $_POST['deletePhone'];
  $conn = new mysqli($hn, $un, $pw, $db);
  if($conn->connect_error) die('Fatal error');
  $query = "DELETE FROM telefoon WHERE telefoonnummer='$deletePhone'";
  $conn->query($query);
  if(!$result) die('delete mail query fail');
  // prevent refresh data insertion
  unset($_POST);
  ?> <script>window.location.href = '/feedback/eindopdracht/ledenlijst.php';</script> <?php
  echo 'removed succesfully';
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

.card {
  background-color: lavender;
  width: 325px;
  padding: 5px;
  padding-top: 25px;
  text-align: center;
}

.container {
  display: flex;
  flex-wrap: wrap;
  gap: 50px;
}
</style>