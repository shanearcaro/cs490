<?php
    session_start();
    // Read posted user data from the front end
    $user_data = file_get_contents('php://input');

    // Connection for the middle end
    $url = 'localhost/src/backend/insertCompletedExam.php';

    // Initialized a cURL session
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $user_data);

    // Decode the results of sending the data
    $result = curl_exec($ch);
    curl_close($ch);
    echo $result;

    // Make middle into one file instead of validateX
?>