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
    $query = "SELECT ce.studentExamID, ce.questionID, ce.answer, eq.questionPoints FROM CompletedExam AS ce
                INNER JOIN StudentExams AS se ON ce.studentExamID=se.studentExamID
                INNER JOIN ExamQuestions AS eq on se.examID=eq.examID AND ce.questionID=eq.questionID
                WHERE ce.studentExamID='{$studentExamID}';";
    $result = mysqli_query($connection, $query);
    while ($row = mysqli_fetch_array($result)) {
        $questionID = $row['questionID'];
        $answer = $row['answer'];
        $points = $row['questionPoints'];
        $questionResponse = array('questionID'=>$questionID, 'answer'=>$answer, 'points'=>$points);
        array_push($questionAnswers, $questionResponse);
    }

    $response = json_encode($questionAnswers);
    echo $response;

    $connection->close();
 ?>