<?php
    session_start();
    // Get username and password from Malcolm's login screen and create a data array
    $question  = $_POST['questionBox'];
    $testcase1 = $_POST['testCase1'];
    $caseAnswer1 = $_POST['caseAnswer1'];
    $testcase2 = $_POST['testCase2'];
    $caseAnswer2 = $_POST['caseAnswer2'];
    $accountID = $_SESSION['accountID'];

    $data = array('question' => $question, 'testcase1' => $testcase1, 'caseAnswer1' => $caseAnswer1,
    'testcase2' => $testcase2, 'caseAnswer2' => $caseAnswer2, 'accountID' => $accountID);

    // Encode the data into JSON format
    $encoded = json_encode($data);

    // Connection for the middle end
    $url = 'localhost/src/middle/validateQuestion.php';

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


    // Update page on success
    if ($result == "Success") {
        echo "<script>alert('Question created successfully.');</script>";
    }
    else {
        echo "<script>alert('Question failed to create.');</script>";
    }
    echo "<script>window.location.href='/src/frontend/TeacherPages/teacher.php';</script>";
?>