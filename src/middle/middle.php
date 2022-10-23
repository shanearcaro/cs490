<?php
    // Read posted user data from the front end
    $user_data = json_decode(file_get_contents('php://input'), true);

    // Pulls the backend url from the array and removes it from the array
    $url = array_pop($user_data);
    $encoded = json_encode($user_data);

    // Initialized a cURL session
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $encoded);

    // Decode the results of sending the data
    $result = curl_exec($ch);
    curl_close($ch);
    echo $result;
?>