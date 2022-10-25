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

    // Get the accountID and the examID the user selected to get the StudentExamID
    $accountID = $user_data->{'accountID'};
    $examID = $user_data->{'examID'}[0];

    $query = "SELECT se.studentExamID FROM StudentExams AS se
                INNER JOIN Students AS s ON se.studentID=s.studentID
                WHERE s.accountID='{$accountID}' AND se.examID='{$examID}'";
    $result = mysqli_query($connection, $query);
    $row = mysqli_fetch_array($result);
    $studentExamID = $row['studentExamID'];

    $questionAnswers = array();
    
    // Get all answers for the exam
    $query = "SELECT ce.studentExamID, ce.questionID, ce.answer, ce.result1, ce.result2, ce.score, ce.comment, eq.questionPoints, q.question, q.testcase1, q.caseAnswer1, q.testcase2, q.caseAnswer2 
                FROM CompletedExam AS ce
                INNER JOIN StudentExams AS se ON ce.studentExamID=se.studentExamID
                INNER JOIN ExamQuestions AS eq ON se.examID=eq.examID AND ce.questionID=eq.questionID
                INNER JOIN Questions AS q ON ce.questionID=q.questionID
                WHERE ce.studentExamID='{$studentExamID}'";

    /**
     * Results are not being added into the database properly after the auto grader is run 
     * ** Results meaning the result of running the python script
     */

    $result = mysqli_query($connection, $query);
    while ($row = mysqli_fetch_array($result)) {
        $questionID     = $row['questionID'];
        $question       = $row['question'];
        $answer         = $row['answer'];
        $result1        = $row['result1'];
        $result2        = $row['result2'];
        $score          = $row['score'];
        $comment        = $row['comment'];
        $points         = $row['questionPoints'];
        $testcase1      = $row['testcase1'];
        $caseAnswer1    = $row['caseAnswer1'];
        $testcase2      = $row['testcase2'];
        $caseAnswer2    = $row['caseAnswer2'];

        $questionResponse = array(
            'questionID'    => $questionID, 
            'question'      => $question,
            'answer'        => $answer,
            'result1'       => $result1, 
            'result2'       => $result2, 
            'score'         => $score,
            'comment'       => $comment, 
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