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
    $examID = $user_data[0];
    $studentID = $user_data[1];

    // // Get the student exam id for this test
    // $query = "SELECT studentExamID FROM StudentExams WHERE studentID='{$studentID}' AND examID='{$examID}'";
    // $result = mysqli_query($connection, $query);
    // $row = mysqli_fetch_array($result);
    // $studentExamID = $row['studentExamID'];

    // $answers = array();

    // $query = "SELECT questionID, answer FROM CompletedExam WHERE studentID='{$studentExamID}'";
    // $result = mysqli_query($connection, $query);
    // while ($row = mysqli_fetch_array($result)) {
    //     $questionID = $row['questionID'];
    //     $answer = $row['answer'];
    //     $questionAnswer = array($questionID => $answer);
    //     array_push($answers, $questionAnswer);
    // }


    // // Insert question data into question table
    // $query = "SELECT q.questionID FROM ExamQuestions as eq 
    //     INNER JOIN Exams AS e ON eq.examID=e.examID
    //     INNER JOIN Questions AS q ON eq.questionID=q.questionID
    //     WHERE e.examID='{$examID}'"; 
    // $result = mysqli_query($connection, $query);

    // $questions = array();

    // while ($row = mysqli_fetch_array($result)) {
    //     $question = array('questionID' => $row['questionID']); 
    //     array_push($questions, $question);
    // }
    // $response = json_encode($answers);
    $response = json_encode($user_data2);
    echo $response;

    $connection->close();
 ?>