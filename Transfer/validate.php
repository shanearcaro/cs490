<?php
    // Get username and password from Malcolm's login screen.
    $username = $_POST['user'];
    $password = $_POST['password'];

    // Hash the password data so it's not plain text
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $data = array('username' => $username, 'password' => $hashed_password);
    print_r($data);

    // Start curl post data
    // Connect to Ege's backend script
    $url = 'https://web.njit.edu/~sma237/CS490/backend/read.php';

    // Generate URL-encoded query string
    $postdata = http_build_query($data);

    // Initialize a cUrl session
    $connection = curl_init();

    // Set curl variable data requirements
    curl_setopt($connection, CURLOPT_URL, $url);
    curl_setopt($connection, CURLOPT_POST, count($data));
    curl_setopt($connection, CURLOPT_POSTFIELDS, $postdata);

    // Post the data
    $result = curl_exec($connection);
    echo $result;

    // Close connection
    curl_close($connection);
?>