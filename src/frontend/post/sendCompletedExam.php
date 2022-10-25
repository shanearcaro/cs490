<?php
    session_start();

    // Log the user out if the session isn't valid anymore.
    // This can happen because of a refresh or if the url is typed manually and the user doesn't log in.
    if (!isset($_SESSION['accountID'])) {
        echo "<script>alert('Session invalid, logging out.');</script>";
        echo "<script>window.location.href='/';</script>";
        exit();
        
    }

    $answers = array();
    if (isset($_POST['answer'])) {
        for ($i = 0; $i < count($_POST['answer']); $i++) {
            $answers[$i] = $_POST['answer'][$i];
        }
    }

    //URL for the backend
    $backend_url = 'https://afsaccess4.njit.edu/~mcs43/src/backend/insertCompletedExam.php';

    // Need to send the examID and the accountID with the answers
    array_push($answers, $_SESSION['examID']);
    array_push($answers, $_SESSION['accountID']);

    //Need to add the url to the backend as well.
    array_push($answers, $backend_url);

    // Encode the data into JSON format
    $encoded = json_encode($answers);

    // Connection for the middle end
    $url = 'https://afsaccess4.njit.edu/~mcs43/src/middle/middle.php';

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
        echo "<script>alert('Exam submitted successfully.');</script>";
    }
    else {
        echo "<script>alert('Exam failed to submit.');</script>";
    }
    echo "<script>window.location.href='https://afsaccess4.njit.edu/~mcs43/src/frontend/StudentPages/student.php';</script>";

?>