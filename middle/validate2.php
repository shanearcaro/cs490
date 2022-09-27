<?php
    // Get username and password from Malcolm's login screen.
    $username = $_POST['user'];
    $password = $_POST['password'];

    // Hash the password data so it's not plain text
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $data = array('username' => $username, 'password' => $hashed_password);

    // Start curl post data
    // Connect to Ege's backend script
    // https://web.njit.edu/~sma237/CS490/backend/read.php
    $url = '../backend/query.php';

    // Initialize a cUrl session
    $connection = curl_init();

    // Set curl variable data requirements
    curl_setopt($connection, CURLOPT_URL, $url);
    curl_setopt($connection, CURLOPT_POST, true);
    curl_setopt($connection, CURLOPT_RETURNTRANSFER, true);

    curl_setopt($connection, CURLOPT_POSTFIELDS, http_build_query($data));

    // Post the data
    $result = curl_exec($connection);
    echo $result;

    // Close connection
    curl_close($connection);
?>