<?php
require_once 'login.php';

$user = "LOIDocent";
$pass = "mysqlphp";

// set up connection
$conn = new mysqli($hn, $un, $pw, $db);
if($conn->connect_error) die('Fatal error');

// check for credential cookies
if(isset($_COOKIE['un']) &&
   isset($_COOKIE['pw'])) {
    $un = mysql_entities_fix_string($conn, $_COOKIE['un']);
    $pw = mysql_entities_fix_string($conn, $_COOKIE['pw']);
    $query = "SELECT * FROM users WHERE username='$un'";
    $result = $conn->query($query);
    if(!$result) die('User not found');
    elseif($result->num_rows) {
      $row = $result->fetch_array(MYSQLI_NUM);
      $result->close();
      
      // match unhashed password
      if(password_verify($pw, $row[3])) {
        echo '<div style="background-color: lightgreen; padding: 5px; color: white; display: flex; justify-content: center">';
        echo htmlspecialchars("$row[0] $row[1] : Hallo $row[0], U bent nu ingelogd als zijnde '$row[2]'");
        echo '</div>';
        // set cookies for credentials, duration max 24 hours
        if($_COOKIE['un'] != $un && $_COOKIE['pw'] != $pw)
          setcookie('un', $un, time() + 60 * 60 * 24, '/');
          setcookie('pw', $pw, time() + 60 * 60 * 24, '/');
      } else die("Invalid username/pass combination");
    } else die("Invalid username/pass combination");
} else {
  if(isset($_SERVER['PHP_AUTH_USER']) &&
   isset($_SERVER['PHP_AUTH_PW'])) {
    // sanitize inputs
    $un_temp = mysql_entities_fix_string($conn, $_SERVER['PHP_AUTH_USER']);
    $pw_temp = mysql_entities_fix_string($conn, $_SERVER['PHP_AUTH_PW']);
    $query = "SELECT * FROM users WHERE username='$un_temp'";
    $result = $conn->query($query);
    if(!$result) die('User not found');
    elseif($result->num_rows) {
      $row = $result->fetch_array(MYSQLI_NUM);
      $result->close();
      
      // match unhashed password
      if(password_verify($pw_temp, $row[3])) {
        echo htmlspecialchars("$row[0] $row[1] : Hi $row[0], you are now logged in as '$row[2]'");
        // set cookies for credentials, duration max 24 hours
        setcookie('un', $un_temp, time() + 60 * 60 * 24, '/');
        setcookie('pw', $pw_temp, time() + 60 * 60 * 24, '/');
      } else die("Invalid username/pass combination");
    } else die("Invalid username/pass combination");
  } else {
    header('WWW-Authenticate: Basic realm="Restricted Area"');
    header('HTTP/1.0 401 Unauthorized');
    die("Please enter username and password");
  }
} $conn->close();

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
      <nav style="display: flex; justify-content: space-evenly;">
        <a style="background-color: greenyellow; color: black; box-shadow: 5px 10px 8px #888888; text-decoration: none; border-radius: 5px; padding: 15px;" href="home.php">Home</a>
        <a style="background-color: greenyellow; color: black; box-shadow: 5px 10px 8px #888888; text-decoration: none; border-radius: 5px; padding: 15px;" href="ledenlijst.php">Ledenlijst</a>
        <a style="background-color: greenyellow; color: black; box-shadow: 5px 10px 8px #888888; text-decoration: none; border-radius: 5px; padding: 15px;" href="/feedback/eindopdracht/wijzigen.php">Lid wijzigen</a>
        <a style="background-color: greenyellow; color: black; box-shadow: 5px 10px 8px #888888; text-decoration: none; border-radius: 5px; padding: 15px;" href="/feedback/eindopdracht/postcode.php">Postcodes toevoegen</a>
        <a style="background-color: greenyellow; color: black; box-shadow: 5px 10px 8px #888888; text-decoration: none; border-radius: 5px; padding: 15px;" href="/feedback/eindopdracht/email.php">Email toevoegen</a>
        <a style="background-color: greenyellow; color: black; box-shadow: 5px 10px 8px #888888; text-decoration: none; border-radius: 5px; padding: 15px;" href="/feedback/eindopdracht/telefoon.php">Telefoon toevoegen</a>
        <a style="background-color: greenyellow; color: black; box-shadow: 5px 10px 8px #888888; text-decoration: none; border-radius: 5px; padding: 15px;" href="/feedback/eindopdracht/teams.php">Team samenstellen</a>
        <a style="background-color: greenyellow; color: black; box-shadow: 5px 10px 8px #888888; text-decoration: none; border-radius: 5px; padding: 15px;" href="remove.php">Teamleden verwijderen</a>
      </nav>

      <h1>Dit is de homepagina van vereniging. Leden toevoegen kan bij de ledenlijst!</h1>
_END;

// create credentials for authentication
$forename = "Henk";
$surname = "de Ridder";
$username = "LOIDocent";
$password = "mysqlphp";
$hash = password_hash($password, PASSWORD_DEFAULT);
// add_user($conn, $forename, $surname, $username, $hash);

function add_user($conn, $fn, $sn, $un, $pw) {
  $stmt = $conn->prepare('INSERT INTO users Values(?,?,?,?)');
  $stmt->bind_param('ssss', $fn, $sn, $un, $pw);
  $stmt->execute();
  $stmt->close();
}

function mysql_entities_fix_string($conn, $string)
{
  return htmlentities(mysql_fix_string($conn, $string));
}    

function mysql_fix_string($conn, $string)
{
  if (get_magic_quotes_gpc()) $string = stripslashes($string);
  return $conn->real_escape_string($string);
}