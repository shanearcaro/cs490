<?php
    session_start();

    $db_credentials = include 'credentials.php';

    $connection = new mysqli($db_credentials['HOST'], $db_credentials['NAME'], $db_credentials['PASS'], $db_credentials['DATABASE']);

    // Prompt error if database connection doesn't work and exit the script
    if ($connection->connect_error) {
	    echo "Failed to connect to MYSQL: " . mysqli_connect_error();
        exit();
    }

    // Read posted user data from the front end
    $user_data = json_decode(file_get_contents('php://input'));
    
    // Data received is already json encoded
    // Instead of decoding to just encode just send encoded data
    $accountID = $user_data->{'accountID'};

    // We have the accountID but to create an exam we need the teacherID
    $query = "SELECT teacherID FROM Teachers WHERE accountID='{$accountID}'";
    $result = mysqli_query($connection, $query);
    $row = mysqli_fetch_array($result);
    $teacherID = $row['teacherID'];
    
    //Insert question data into question table
    $query = "SELECT * FROM Questions WHERE teacherID='{$teacherID}'"; 
    $result = mysqli_query($connection, $query);

    $questions = array();

    while ($row = mysqli_fetch_array($result)) {
        $question = array('questionID' => $row['questionID'], 'question' => 
            $row['question'], 'testcase1' => $row['testcase1'], 'testcase2' => $row['testcase2']);
        array_push($questions, $question);
    }

    $response = count($questions) == 0 ? "Empty" : $questions;
    $response = json_encode($response);
    echo $response;

    $connection->close();
 ?>