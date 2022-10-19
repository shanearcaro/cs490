<?php
    session_start();
    // Read posted user data from the front end
    $user_data = json_decode(file_get_contents('php://input'));

    $question = $user_data->{'question'};
    $testcase1 = $user_data->{'testcase1'};
    $testcase2 = $user_data->{'testcase2'};

    $data = array('question' => $question, 'testcase1' => $testcase1, 'testcase2' => $testcase2);

    // Encode the data into JSON format
    $encoded = json_encode($data);

    // Connection for the middle end
    $url = 'localhost/src/backend/insertQuestion.php';

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