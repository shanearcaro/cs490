<?php
    session_start();
    require_once realpath(dirname(__DIR__, 2) . '/vendor/autoload.php');

    // Read from credentials file and connect to database
    $dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__, 2));
    $dotenv->load();

    $connection = new mysqli($_ENV['HOST'], $_ENV['NAME'], $_ENV['PASS'], $_ENV['DATABASE']);

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
    while ($row = mysqli_fetch_array($result)) {
        $teacherID = $row['teacherID'];
    }
    
    //Insert question data into question table
    $query = "SELECT * FROM Questions WHERE teacherID='{$teacherID}'"; 
    $result = mysqli_query($connection, $query);

    $questions = array();

    while ($row = mysqli_fetch_array($result)) {
        $question = array('questionID' => $row['questionID'], 'question' => 
            $row['question'], 'testcase1' => $row['testcase1'], 'testcase2' => $row['testcase2']);
        array_push($questions, $question);
    }

    $response = json_encode($questions);
    echo $response;

    $connection->close();
 ?>