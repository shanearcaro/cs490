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
    $user_data2 = file_get_contents('php://input');
        
    // Data received is already json encoded
    // Instead of decoding to just encode just send encoded data
    $accountID = $user_data[0];
    $studentExamID = $user_data[1];

    $questionAnswers = array();
    
    // Get all answers for the exam
    $query = "SELECT questionID, answer FROM CompletedExam WHERE studentExamID='{$studentExamID}'";
    $result = mysqli_query($connection, $query);
    while ($row = mysqli_fetch_array($result)) {
        $questionID = $row['questionID'];
        $answer = $row['answer'];
        $questionResponse = array($questionID=>$answer);
        array_push($questionAnswers, $questionResponse);
    }

    $response = json_encode($questionAnswers);
    echo $response;

    $connection->close();
 ?>