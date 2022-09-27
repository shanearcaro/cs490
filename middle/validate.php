<?php
    // Get username and password from Malcolm's login screen.
    session_start();
    $user_data = file_get_contents('php://input');
    
    $data = json_decode($user_data);
    $username = $data->{'username'};
    $password = $data->{'password'};

    $data = array('username' => $username, 'password' => $password);

    // Encode the data into JSON format
    $encoded = json_encode($data);
    // print_r($encoded);

    $url = 'https://afsaccess4.njit.edu/~sma237/CS490/backend/auth.php';

    // Initialized a cURL session
    $ch = curl_init($url);

    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    // curl_setopt($ch, CURLOPT_HEADER, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $encoded);

    // header('Location: ../backend/query.php');

    $result = curl_exec($ch);
    //$response = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    echo json_encode($result);

?>
