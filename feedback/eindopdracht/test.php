<?php
require_once 'login.php';
// set up connection
$conn = new mysqli($hn, $un, $pw, $db);
if($conn->connect_error) die('Fatal error');

// we echo html to add teammembers
echo <<<_END
<form action="" method="post" style="padding: 30px; background-color: cornflowerblue;"><pre>
    Teamnaam        <select name="teamnaam" id="teamnaam" required>
_END;

// set up query for teamnaam dropdown
$query = "SELECT * FROM teams";
$result = $conn->query($query);
if(!$result) die('lidnr query failed');

$teamRows = $result->num_rows;

for($i = 0; $i < $teamRows; ++$i) {
    $teamRow = $result->fetch_array(MYSQLI_NUM);
    // lidnr column is at lidnrRow[0]
    $teamnaam = htmlspecialchars($teamRow[0]);
    // we echo the result inside of the loop
    echo <<<_END
    <option value="$teamnaam">$teamnaam</option>
    _END;
}

echo <<<_END
</select><br>
                    <input type="submit">
</form>
_END;

echo '<pre>';
print_r($_POST['teamnaam']);
echo '</pre>';

echo <<<_END
<form action="" method="post" style="padding: 30px; background-color: cornflowerblue;"><pre>
    Teamlid        <select name="teamlid" id="teamlid" required>
_END;

// query select * from teamlid where teamnaam=$_POST[teamnaam]
// query select * from teamlid where teamnaam=$_POST[teamnaam]
// query select * from teamlid where teamnaam=$_POST[teamnaam]
// query select * from teamlid where teamnaam=$_POST[teamnaam]
// query select * from teamlid where teamnaam=$_POST[teamnaam]
// query select * from teamlid where teamnaam=$_POST[teamnaam]
// query select * from teamlid where teamnaam=$_POST[teamnaam]
// query select * from teamlid where teamnaam=$_POST[teamnaam]
// query select * from teamlid where teamnaam=$_POST[teamnaam]




// echo <<<_END
//     Lidnummer       <select name="lidnummer" id="lidnummer" required>
// _END;

// // set up query for lidnr dropdown
// $query = "SELECT * FROM teamlid WHERE teamnaam='pokemon'";
// $result = $conn->query($query);
// if(!$result) die('lidnr query failed');

// $lidnrRows = $result->num_rows;

// for($i = 0; $i < $lidnrRows; ++$i) {
//     $lidnrRow = $result->fetch_array(MYSQLI_NUM);
//     // lidnr column is at lidnrRow[0]
//     $lidnr = htmlspecialchars($lidnrRow[0]);
//     $voornaam = htmlspecialchars($lidnrRow[1]);
//     $achternaam = htmlspecialchars($lidnrRow[2]);
//     // we echo the result inside of the loop
//     echo <<<_END
//     <option value="$lidnr">#$lidnr $voornaam $achternaam</option>
//     _END;
// }

// // outside the loop we continue with echoing the HTML
// echo <<<_END
// </select>
//                     <input type="hidden" name="removefromteam" value="yes">
//                     <input type="submit" value="Lid verwijderen van team">
// </form>
// </pre>
// </body>
// </html>
// _END;