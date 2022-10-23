<?php
    session_start();

    // Log the user out if the session isn't valid anymore.
    // This can happen because of a refresh or if the url is typed manually and the user doesn't log in.
    if (!isset($_SESSION['accountID'])) {
        echo "<script>alert('Session invalid, logging out.');</script>";
        echo "<script>window.location.href='/';</script>";
        exit();
        
    }
    
    // Get username and password from Malcolm's login screen and create a data array
    $username = $_POST['username'];
    $password = $_POST['password'];

    $data = array('username' => $username, 'password' => $password);

    $backend_url = 'localhost/src/backend/authenticateLogin.php';
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


    $accountType = $result->{'type'};
    $accountID = $result->{'accountID'};
    $_SESSION['accountID'] = $accountID;

    // Contacting the back end will return Student, Teacher, or Bad Login.
    // Update the current page depending on the result from the database.
    if ($accountType == "Student") {
        echo "<script>window.location.href='/src/frontend/StudentPages/student.php';</script>";
    }
    else if ($accountType == "Teacher") {
        echo "<script>window.location.href='/src/frontend/TeacherPages/teacher.php';</script>";
    }
    else {
        echo "<script>alert('Invalid Credentials');window.location.href='/';</script>";
    }
?>