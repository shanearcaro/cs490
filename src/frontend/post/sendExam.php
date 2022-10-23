<?php
    session_start();
    $questionBank = array();
    $pointsBank = array();
    // Need to remove all unset values from points
    for ($i = 0; $i < count($_POST['checkBox']); $i++) {
        $points = $_POST['points'][$_POST['checkBox'][$i] - 1];
        array_push($pointsBank, $points);
    }

    if (isset($_POST['checkBox'])) {
        for ($i = 0; $i < count($_POST['checkBox']); $i++) {
            $questionBank[$_POST['checkBox'][$i]] = $pointsBank[$i];
        }
    }
    $backend_url = 'localhost/src/backend/insertExam.php';
    array_push($questionBank, $_SESSION['accountID']);
    array_push($questionBank, $backend_url);

    // Encode the data into JSON format
    $encoded = json_encode($questionBank);

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

    /**
     * Exams can be successfully created now. Need to decide here where to go once and exam is created
     * or if it fails. The value of $result is either going to be Exam Created or Empty Exam.
     * 
     * Students need to be able to view all the exams created by teachers and be able to take the exams.
     * Once this happens I can finally start working on the auto grader.
     * 
     * 
     * Also if you have time: implement some Javascript to put a counter on the screen of the point values when creating an exam.
     * ALso should change how the input box works on exams so that it only accepts number input.
     */
?>