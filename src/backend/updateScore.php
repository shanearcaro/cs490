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

    $accountID = array_pop($user_data);
    $studentExamID = array_pop($user_data);
    $totalPoints = 0;

    $response = "Success";

    // Loop through every reviewed question and update the score in the database
    for ($i = 0; $i < count($user_data); $i++) {
        $record = $user_data[$i];
        $score = $record->{'score'};
        $comment = $record->{'comment'};
        $questionID = $record->{'questionID'};
        $result1 = $record->{'result1'};
        $result2 = $record->{'result2'};
        $totalPoints += $score;

        $query = "UPDATE CompletedExam SET score='{$score}', comment='{$comment}', result1='{$result1}', result2='{$result2}' WHERE questionID='{$questionID}' AND studentExamID='{$studentExamID}'";
        $result = mysqli_query($connection, $query);
        if (!$result)
            $response = "Failure";
    }
    // Update the students overall exam score
    $query = "UPDATE StudentExams SET score='{$totalPoints}' WHERE studentExamID='{$studentExamID}'";
    $result = mysqli_query($connection, $query);
    if (!$result)
            $response = "Failure";
    
    $response = json_encode($response);
    echo $response;

    $connection->close();
 ?>