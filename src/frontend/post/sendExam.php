<?php
    session_start();

    // Log the user out if the session isn't valid anymore.
    // This can happen because of a refresh or if the url is typed manually and the user doesn't log in.
    if (!isset($_SESSION['accountID'])) {
        echo "<script>alert('Session invalid, logging out.');</script>";
        echo "<script>window.location.href='/';</script>";
        exit();
    }

    $questionBank = array();

    if (isset($_POST['checkBox'])) {
        for ($i = 0; $i < count($_POST['checkBox']); $i++) {
            $questionBank[$_POST['checkBox'][$i]] = $_POST['points'][$i];
        }
    }
    $backend_url = 'localhost/src/backend/insertExam.php';
    array_push($questionBank, $_SESSION['accountID']);
    array_push($questionBank, $backend_url);

    // Encode the data into JSON format
    $encoded = json_encode($questionBank);
    echo $encoded;

    // Connection for the middle end
    $url = 'localhost/src/middle/middle.php';

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