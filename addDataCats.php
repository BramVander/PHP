<?php
    require_once 'login.php';
    $conn = new mysqli($hn, $un, $pw, $db);
    if($conn->connect_error) die("fatal fail");

    // $query = "INSERT INTO cats VALUES(NULL, 'Lion', 'Leo', 4)";
    // $query = "INSERT INTO cats VALUES(NULL, 'Cougar', 'Growler', 4)";
    // $query = "INSERT INTO cats VALUES(NULL, 'Cheetah', 'Charly', 3)";
    $query = "INSERT INTO cats VALUES(NULL, 'Lynx', 'Stumpy', 5)";
    $result = $conn->query($query);
    if(!$result) die("db access failed");

    echo "The insert ID was: " . $conn->insert_id;
?>