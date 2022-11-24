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
              <a style="background-color: greenyellow; color: black; box-shadow: 5px 10px 8px #888888; text-decoration: none; border-radius: 5px; padding: 15px;" href="schoon.php">Lid verwijderen</a>
              <a style="background-color: greenyellow; color: black; box-shadow: 5px 10px 8px #888888; text-decoration: none; border-radius: 5px; padding: 15px;" href="/feedback/eindopdracht/wijzigen.php">Lid wijzigen</a>
              <a style="background-color: greenyellow; color: black; box-shadow: 5px 10px 8px #888888; text-decoration: none; border-radius: 5px; padding: 15px;" href="/feedback/eindopdracht/postcode.php">Postcodes toevoegen</a>
              <a style="background-color: greenyellow; color: black; box-shadow: 5px 10px 8px #888888; text-decoration: none; border-radius: 5px; padding: 15px;" href="/feedback/eindopdracht/email.php">Email toevoegen</a>
              <a style="background-color: greenyellow; color: black; box-shadow: 5px 10px 8px #888888; text-decoration: none; border-radius: 5px; padding: 15px;" href="/feedback/eindopdracht/telefoon.php">Telefoon toevoegen</a>
            </nav>
_END;

// set up query to show all members
$query = "SELECT * FROM leden";
$result = $conn->query($query);
if(!$result) die('query failed');

$rows = $result->num_rows;

echo <<<_END
<h1>LEDEN VERWIJDEREN</h1>
<div style="display: flex; flex-direction: row; gap: 20px; flex-wrap: wrap;">
_END;

// loop through results to display members
for($i = 0; $i < $rows; ++$i) {
    // assign records from result to row
    $row = $result->fetch_array(MYSQLI_NUM);
    // lidnummer column is at row[0]
    $r0 = htmlspecialchars($row[0]);
    // name column is at row[1]
    $r1 = htmlspecialchars($row[1]);

    echo <<<_END
    <pre style="background-color: indianred; width: 325px;">
    <form method="post" action="">
        Lidnaam: $r1
        Lidnummer: $r0
        <input type="hidden" name="delete" value="$r0">
        <input type="submit" value="Lid verwijderen">
    </form></pre>
    _END;
}