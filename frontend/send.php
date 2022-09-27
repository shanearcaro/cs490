<?php
    // Get username and password from Malcolm's login screen.
    $username = $_POST['username'];
    $password = $_POST['password'];

    $data = array('user' => $username, 'password' => $password);

    // Encode the data into JSON format
    $encoded = json_encode($data);
    // print_r($encoded);

    $url = 'https://afsaccess4.njit.edu/~sma237/CS490/middle/validate.php';

    // Initialized a cURL session
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $encoded);

    // header('Location: ../backend/query.php');

    $result = curl_exec($ch);
    curl_close($ch);
    echo $result;
?>
