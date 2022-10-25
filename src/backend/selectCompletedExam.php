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
    $accountID = $user_data[0];
    $studentExamID = $user_data[1];

    $questionAnswers = array();
    
    // Get all answers for the exam
    $query = "SELECT ce.studentExamID, ce.questionID, ce.answer, eq.questionPoints, q.question, q.testcase1, q.caseAnswer1, q.testcase2, q.caseAnswer2 
                FROM CompletedExam AS ce
                INNER JOIN StudentExams AS se ON ce.studentExamID=se.studentExamID
                INNER JOIN ExamQuestions AS eq ON se.examID=eq.examID AND ce.questionID=eq.questionID
                INNER JOIN Questions AS q ON ce.questionID=q.questionID
                WHERE ce.studentExamID='{$studentExamID}'";

    $result = mysqli_query($connection, $query);
    while ($row = mysqli_fetch_array($result)) {
        $questionID     = $row['questionID'];
        $question     = $row['question'];
        $answer         = $row['answer'];
        $points         = $row['questionPoints'];
        $testcase1      = $row['testcase1'];
        $caseAnswer1    = $row['caseAnswer1'];
        $testcase2      = $row['testcase2'];
        $caseAnswer2    = $row['caseAnswer2'];

        $questionResponse = array(
            'questionID'    => $questionID, 
            'question'    => $question,
            'answer'        => $answer, 
            'points'        => $points,
            'testcase1'     => $testcase1,
            'caseAnswer1'   => $caseAnswer1,
            'testcase2'     => $testcase2,
            'caseAnswer2'   => $caseAnswer2,
        );
        array_push($questionAnswers, $questionResponse);
    }

    $response = json_encode($questionAnswers);
    echo $response;

    $connection->close();
 ?>