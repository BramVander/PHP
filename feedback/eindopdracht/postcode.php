<?php
    require_once 'login.php';
    $link = mysqli_connect($hn, $un, $pw, $db);
    if(mysqli_connect_errno()) die('Fatal error');

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
        <br>
    _END;

  // get inputs from $_POST
  // sanitize
  // write to according variable
  if (isset($_POST['postcode'])    &&
      isset($_POST['adres'])       &&
      isset($_POST['woonplaats'])) {
          $postcode   = mysql_entities_fix_string($link, $_POST['postcode']);
          $adres      = mysql_entities_fix_string($link, $_POST['adres']);
          $woonplaats = mysql_entities_fix_string($link, $_POST['woonplaats']);
      }

  // prepare statement
  $stmt = mysqli_prepare($link, 'INSERT INTO postcode VALUES(?,?,?)');
  // bind statement params
  mysqli_stmt_bind_param($stmt, 'sss', $postcode, $adres, $woonplaats);
  // execute statement
  mysqli_stmt_execute($stmt);
  // close statement
  mysqli_stmt_close($stmt);
  // close mysql connection
  mysqli_close($link);

  // echo form to add postcode
  echo <<<_END
  <form action="postcode.php" method="post" style="padding: 30px; background-color: cornflowerblue;"><pre>
      Postcode        <input type="text" name="postcode">
      Adres           <input type="text" name="adres">
      Woonplaats      <input type="text" name="woonplaats">
                      <input type="submit" value="Postcode toevoegen">
  </pre></form>
  _END;   
} else {
  header("Location: home.php");
}

// sanitize functions
function mysql_entities_fix_string($conn, $string)
{
  return htmlentities(mysql_fix_string($conn, $string));
}    

function mysql_fix_string($conn, $string)
{
  if (get_magic_quotes_gpc()) $string = stripslashes($string);
  return $conn->real_escape_string($string);
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
</style>