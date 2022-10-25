<?php
    session_start();

    // Log the user out if the session isn't valid anymore.
    // This can happen because of a refresh or if the url is typed manually and the user doesn't log in.
    if (!isset($_SESSION['accountID'])) {
        echo "<script>alert('Session invalid, logging out.');</script>";
        echo "<script>window.location.href='/';</script>";
        exit();
    }

    $scores = $_POST['score'];
    $comments = $_POST['comment'];
    $questionID = $_POST['questionID'];
    $studentExamID = $_POST['studentExamID'];
    $result1 = $_POST['result1'];
    $result2 = $_POST['result2'];
    $data = array();

    for ($i = 0; $i < count($scores); $i++) {
        $row = array('score'=>$scores[$i], 'comment'=>$comments[$i], 'questionID'=>$questionID[$i], 'result1'=>$result1[$i], 'result2'=>$result2[$i]);
        array_push($data, $row);
    }
    array_push($data, $studentExamID);

    $backend_url = 'localhost/src/backend/updateScore.php';
    array_push($data, $_SESSION['accountID']);
    array_push($data, $backend_url);

    // Encode the data into JSON format
    $encoded = json_encode($data);

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

    if ($result == "Success") {
        echo "<script>alert('Exam graded successfully.');</script>";
    }
    else {
        echo "<script>alert('Exam failed to grade.');</script>";
    }
    echo "<script>window.location.href='/src/frontend/TeacherPages/teacher.php';</script>";

?>