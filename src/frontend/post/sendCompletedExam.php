<?php
    session_start();
    $questionBank = array();
    if (isset($_POST['checkBox'])) {
        for ($i = 0; $i < count($_POST['checkBox']); $i++) {
            $questionBank[$_POST['checkBox'][$i]] = $_POST['points'][$i];
        }
    }
    array_push($questionBank, $_SESSION['accountID']);

    // Encode the data into JSON format
    $encoded = json_encode($questionBank);

    // Connection for the middle end
    $url = 'localhost/src/middle/validateExam.php';

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

    if ($result == "Exam Created") {
        echo "<script>alert('Exam created successfully.');</script>";
    }
    else {
        echo "<script>alert('Exam failed to create.');</script>";
    }
    echo "<script>window.location.href='/src/frontend/TeacherPages/teacher.php';</script>";

?>