<?php
    include_once "../env/database.php";

    // Connect to SQL database
    $connection = mysqli_connect($server, $username, $password, $database);

    // Check for connection error
    if (mysqli_connect_error()) {
        echo "<h1>" . mysql_connect_error() . "</h1>";
        echo "Failed to connect to MYSQL: " . mysql_connect_error();
    }

?>