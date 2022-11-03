<?php
    require_once 'login.php';
    $conn = new mysqli($hn, $un, $pw, $db);
    if($conn->connect_error) die("fatal fail");

    $query = "UPDATE cats SET name='Charlie' WHERE name='Charly'";
    $result = $conn->query($query);
    if(!$result) die("query failed");
?>