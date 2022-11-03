<?php
    require_once 'login.php';
    $conn = new mysqli($hn, $un, $pw, $db);
    if($conn->connect_error) die('connection failed');

    $query = "SELECT * FROM classics";
    $result = $conn->query($query);


    if (!$result) die("query failed");
    
    $rows = $result->num_rows;

    // for($i = 0; $i < $rows; ++$i ) {
    //     $result->data_seek($i);
    //     echo 'Author: ' .htmlspecialchars($result->fetch_assoc()['author']) .'<br>';
    //     $result->data_seek($i);
    //     echo 'Title: ' .htmlspecialchars($result->fetch_assoc()['title']) .'<br>';
    //     $result->data_seek($i);
    //     echo 'Category: ' .htmlspecialchars($result->fetch_assoc()['category']) .'<br>';
    //     $result->data_seek($i);
    //     echo 'Year: ' .htmlspecialchars($result->fetch_assoc()['year']) .'<br>';
    //     $result->data_seek($i);
    //     echo 'ISBN: ' . htmlspecialchars($result->fetch_assoc()['isbn']) .'<br>' . '<br>';
    // }

    for($j = 0; $j < $rows; ++$j) {
        $row = $result->fetch_array(MYSQLI_ASSOC);

        echo '<pre>';
        print_r($row);
        echo '<br>';
        print_r("Author: " . htmlspecialchars($row['author']) . '<br>');
        print_r("Title: " . htmlspecialchars($row['title']) . '<br>');
        print_r("Category: " . htmlspecialchars($row['category']) . '<br>');
        print_r("Year: " . htmlspecialchars($row['year']) . '<br>');
        print_r("ISBN: " . htmlspecialchars($row['isbn']) . '<br><br>');
    }

    $result->close();
    $conn->close();
?>