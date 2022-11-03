<?php
    require_once 'login.php';
    $conn = new mysqli($hn, $un, $pw, $db);
    if($conn->connect_error) die("fatal fail");

    $query = "SELECT * FROM cats";
    $result = $conn->query($query);
    if(!$result) die("query failed");

    $rows = $result->num_rows;

    echo "<table><tr><th>id</th><th>Family</th><th>Name</th><th>Age</th>";

    for($j = 0; $j < $rows; ++$j) {
        $row = $result->fetch_array(MYSQLI_NUM);
        echo "<tr>";
        for($k = 0; $k < 4; ++$k) {
            echo "<td>" . htmlspecialchars($row[$k]) . "</td>";
        }
        echo "</tr>";
    }
    echo "</table>";
?>