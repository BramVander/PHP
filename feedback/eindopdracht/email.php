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
            </nav>
    _END;

    // get inputs from $_POST
    // sanitize
    // write to according variable
    if (isset($_POST['email'])    &&
        isset($_POST['lidnr'])) {
            $lidnr = sanitizeString($_POST['lidnr']);
            $email = sanitizeString($_POST['email']);
    }
    // prepare stmt
    $stmt = $conn->prepare("INSERT INTO email (email, lidnummer) VALUES(?,?)");
    // bind params
    $stmt->bind_param('ss', $email, $lidnr);
    // execute stmt
    $stmt->execute();
    // close conn and stmt
    $stmt->close();
    $conn->close();

    // echo form to add email
    echo <<<_END
    <form action="email.php" method="post" style="padding: 30px; background-color: cornflowerblue;"><pre>
        Email           <input type="text" name="email" required>
        Lidnummer       <select name="lidnummer" id="lidnummer" required>
    _END;

  $hn = 'localhost';
  $db = 'vereniging';
  $un = 'vander';
  $pw = 'mysql';
  $conn = new mysqli($hn, $un, $pw, $db);
  if($conn->connect_error) die('Fatal error');

  // set up query for lidnr dropdown
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

echo <<<_END
  </select>
                    <input type="submit" value="Email toevoegen aan lid">
  </form>
  </pre>
  </body>
  </html>
_END;


function sanitizeString($string) {
    if(get_magic_quotes_gpc())
        $string = stripslashes($string);
    $string = strip_tags($string);
    $string = htmlentities($string);
    return $string;
}
?>