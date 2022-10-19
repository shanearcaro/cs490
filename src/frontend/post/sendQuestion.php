
<?php
    session_start();
    // Get username and password from Malcolm's login screen and create a data array
    $question  = $_POST['questionBox'];
    $testcase1 = $_POST['testCase1'];
    $testcase2 = $_POST['testCase2'];

    $data = array('question' => $question, 'testcase1' => $testcase1, 'testcase2' => $testcase2);

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

    if ($result == "Success") {
        echo "<script>alert('Question created successfully.');</script>";
    }
    else {
        echo "<script>alert('Question failed to create.');</script>";
    }
    echo "<script>window.location.href='../TeacherPages/teacher.php';</script>";
    header("Location: ../TeacherPages/teacher.php");
?>