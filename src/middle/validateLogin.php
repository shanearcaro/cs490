<?php
    // Read posted user data from the front end
    $user_data = json_decode(file_get_contents('php://input'));

    $username = $user_data->{'username'};
    $password = $user_data->{'password'};

    $data = array('username' => $username, 'password' => $password);

    // Encode the data into JSON format
    $encoded = json_encode($data);

    // Connection for the middle end
    $url = 'localhost/src/backend/authenticateLogin.php';

    // Initialized a cURL session
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $encoded);

    // Decode the results of sending the data
    $result = curl_exec($ch);
    echo $result;
    curl_close($ch);
?>