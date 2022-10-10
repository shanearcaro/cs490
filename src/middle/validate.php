<?php
    // Read posted user data from the front end
    session_start();
    $user_data = file_get_contents('php://input');
    
    // Data received is already json encoded
    // Instead of decoding to just encode just send encoded data
    $username = $user_data->{'username'};
    $password = $user_data->{'password'};
    $data = array('username' => $username, 'password' => $password);

    $url = '../backend/auth.php';

    // Initialized a cURL session
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

    $result = curl_exec($ch);
    $response = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    echo $result;
?>
