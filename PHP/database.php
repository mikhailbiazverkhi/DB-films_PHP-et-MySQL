<?php
    if (!defined('ABSPATH'))
        die;
?>


<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "cinémathèque";

    $conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


function query($sql)
{
    global $conn;

    $results = $conn->query($sql);

    $rows = $results->fetch_all(MYSQLI_ASSOC);

    return $rows;
}

