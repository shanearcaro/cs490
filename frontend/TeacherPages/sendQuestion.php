<?php
    //Get the question and test cases that were submitted
    $question = $_POST['textBox'];
    $testCase1 = $_POST['testCase1'];
    $testCase2 = $_POST['testCase2'];

    $data = array('question' => $question, 'testCase1' => $testCase1, 'testCase2' => $testCase2);

    //Encode the data into JSON format
    $encoded = json_encode($data);

    //Send the question to the backend to be stored in the database
    $url = 'somewhere';

    //Initialized the curl session
    $ch = curl_init();
    
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $encoded);
    curl_close($ch);

    header("Location: https://afsaccess4.njit.edu/~mcs43/cs490/frontend/TeacherPages/questionBank.php");
?>