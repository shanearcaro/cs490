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
    $response = "WORKING";

    $accountID = array_pop($user_data);
    $studentExamID = array_pop($user_data);
    $totalPoints = 0;

    $response = $accountID . " " . $studentExamID;


    /**
     * There is a problem here that is not updating the CompletedExam table properly.
     * TotalPoints is calculated properly so we know that user_data is filled properly and at the bare minimum
     * that the score, comment, questionID, and totalPoints code works.
     * 
     * Need to investigate why the page isn't being updated properly.
     */
    for ($i = 0; $i < count($user_data); $i++) {
        $record = $user_data[$i];
        $score = $record->{'score'};
        $comment = $record->{'comment'};
        $questionID = $record->{'questionID'};
        $totalPoints += $score;

        $query = "UPDATE CompletedExam SET score='{$score}', comment='{$comment}' WHERE questionID='{$questionID}' AND studentExamID='{$studentExamID}'";
        mysqli_query($connection, $query);
    }
    $query = "UPDATE StudentExams SET score='{$score}' WHERE studentExamID='{$studentExamID}'";
    mysqli_query($connection, $query);
    
    // Data received is already json encoded
    // Instead of decoding to just encode just send encoded data
    // $question = $user_data->{'question'};
    // $testcase1 = $user_data->{'testcase1'};
    // $caseAnswer1 = $user_data->{'caseAnswer1'};
    // $testcase2 = $user_data->{'testcase2'};
    // $caseAnswer2 = $user_data->{'caseAnswer2'};
    // $accountID = $user_data->{'accountID'};

    // // // We have the accountID but to create an exam we need the teacherID
    // $query = "SELECT teacherID FROM Teachers WHERE accountID='{$accountID}'";
    // $result = mysqli_query($connection, $query);
    // $row = mysqli_fetch_array($result);
    // $teacherID = $row['teacherID'];

    // // //Insert question data into question table
    // $query = "INSERT INTO Questions (teacherID, question, testcase1, caseAnswer1, testcase2, caseAnswer2) 
    //           VALUES ('{$teacherID}', '{$question}', '{$testcase1}', '{$caseAnswer1}', '{$testcase2}', '{$caseAnswer2}')"; 

    // $result = mysqli_query($connection, $query);
    // $response = $result ? "Success" : "Failure";

    // $response = json_encode($response);
    $response = json_encode($response);
    echo $response;

    $connection->close();
 ?>