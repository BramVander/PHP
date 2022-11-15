<?php
require_once 'login.php';

echo <<<_END
<html>
  <head>
    <title>Vereniging</title>
  </head>
  <body>
    <pre>
      <b>Welkom bij de ledenlijst van onze vereniging</b>
      <a href="/feedback/feedback%206/ledenlijst.php">leden+tel+email joined</a>
      <a href="/feedback/feedback%206/postcode.php">Postcodes toevoegen</a>
      <a href="/feedback/feedback%206/email.php">Email toevoegen</a>
      <a href="/feedback/feedback%206/telefoon.php">Telefoon toevoegen</a>

      <form method="post" action="">
        naam        <input type="text" name="naam" size="7">
        postcode    <input type="text" name="postcode" size="7">
        huisnummer  <input type="text" name="huisnummer" size="7">
                    <input type="hidden" name="submitted" value="yes">
                    <input type="submit" value="Lid toevoegen">
      </form>
    </pre>
  </body>
</html>
_END;

// set up connection
$conn = new mysqli($hn, $un, $pw, $db);
if($conn->connect_error) die('Fatal error');

// set up query to show all members
$query = "SELECT * FROM leden";
$result = $conn->query($query);
if(!$result) die('query failed');

$rows = $result->num_rows;

ECHO 'LEDEN VERWIJDEREN';
// loop through results to display members
for($i = 0; $i < $rows; ++$i) {
    // assign records from result to row
    $row = $result->fetch_array(MYSQLI_NUM);
    // lidnummer column is at row[0]
    $r0 = htmlspecialchars($row[0]);
    // name column is at row[1]
    $r1 = htmlspecialchars($row[1]);

    echo <<<_END
    <pre>
    <form method="post" action="">
        Lidnaam: $r1
        Lidnummer: $r0
        <input type="hidden" name="delete" value="$r0">
        <input type="submit" value="Lid verwijderen">
    </form>

    </pre>
    _END;
}

if(isset($_POST['delete'])) {
    $lidnr = $_POST['delete'];

    // prepare query for statement;
    $stmt = $conn->prepare("DELETE FROM leden WHERE lidnummer=$lidnr");
    // execute stmt
    $stmt->execute();
    // close conn and stmt
    $stmt->close();
    $conn->close();
  }

// we check for submit
if (isset($_POST['submitted'])    &&
    isset($_POST['naam'])         &&
    isset($_POST['postcode'])     &&
    isset($_POST['huisnummer'])) {

        // store sanitized inputs
        $naam = sanitizeString($_POST['naam']);
        $postcode = sanitizeString($_POST['postcode']);
        $huisnummer = sanitizeString($_POST['huisnummer']);

        // prepare query for statement;
        $stmt = $conn->prepare('INSERT INTO leden (naam, postcode, huisnummer) VALUES(?,?,?)');
        // bind parameters
        $stmt->bind_param('sss', $naam, $postcode, $huisnummer);
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

