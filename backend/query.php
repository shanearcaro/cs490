<?php
    include_once('https://afsaccess4.njit.edu/~sma237/CS490/env/database.php');
    $user_data = file_get_contents('php://input');
    echo $user_data;

    $username = $userdata['middle_user'];
    $password = $userdata['middle_pass'];

    // Connect to SQL database
    $connection = mysqli_connect($server, $username, $password, $database);

    // Check for connection error
    if (mysqli_connect_error()) 
        echo "Failed to connect to MYSQL: " . mysql_connect_error();

    $query = "SELECT * FROM UserAccounts WHERE username='${username}' AND password='${password}'";
    $result = mysqli_query($connection, $query);
    $size = count(mysqli_fetch_array($result));

    if ($size == 0) {
        // BAD LOGIN
    }
    else {
        echo $query;
    }
?>