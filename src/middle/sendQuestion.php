<?php
    //Get the question and test cases that were submitted
    $question = $_POST['questionBox'];
    $testCase1 = $_POST['testCase1'];
    $testCase2 = $_POST['testCase2'];

    $data = array('question' => $question, 'testCase1' => $testCase1, 'testCase2' => $testCase2);

    //Encode the data into JSON format
    $encoded = json_encode($data);

    //Send the question to the backend to be stored in the database
    $url = 'localhost/src/backend/storeQuestion.php';

    // Initialized a cURL session
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $encoded);

    // Decode the results of sending the data
    $result = curl_exec($ch);
    $result = json_decode($result);
    curl_close($ch);

    echo $result;

    // header("Location: ../frontend/TeacherPages/teacher.php");
?>