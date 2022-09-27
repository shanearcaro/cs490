<?php
    // Get username and password from Malcolm's login screen.
    session_start();
    $username = $_POST['user'];
    $password = $_POST['password'];

    // Hash the password data so it's not plain text
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $data = array('middle_user' => $username, 'middle_password' => $hashed_password);

    // Encode the data into JSON format
    $encoded = json_encode($data);
    // print_r($encoded);

    $url = 'https://web.njit.edu/~sma237/CS490/backend/query.php';

    // Initialized a cURL session
    $ch = curl_init($url);

    if ($ch === false) {
        echo 'Failed to initialize';
    }

    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    // curl_setopt($ch, CURLOPT_HEADER, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 0);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $encoded);

    // header('Location: ../backend/query.php');

    $result = curl_exec($ch);
    $response = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    if ($result == false) 
        echo "Failed ";
    else 
        echo "Accepted ";
    echo "Response: " . $response;
    echo '[' . $result . ']';

?>