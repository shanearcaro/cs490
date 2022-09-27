<?php
    include("credentials.php");
    $connection = mysqli_connect($conn_hostname, $conn_username, $conn_password, $conn_dbname);
    $user_data = file_get_contents('php://input');

    $username = $userdata['middle_user'];
    $password = $userdata['middle_pass'];

    $query = "SELECT username, password, isteacher FROM Users where username='${username}'";
    $result = mysqli_query($connection, $query);

    $size = count(mysqli_fetch_array($result));

    $out = json_encode($result);
    if ($size == 0)
    $out == json_encode(404);

    echo $out;
    mysqli_close($connection);
?>