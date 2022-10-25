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
    $examID = $user_data[0];
    $studentID = $user_data[1];

    // Create new Student Exam
    $query = "INSERT INTO StudentExams (studentID, examID, score) VALUES ('{$studentID}', '{$examID}', -1)";
    mysqli_query($connection, $query);

    // Insert question data into question table
    $query = "SELECT q.questionID, q.question, eq.questionPoints FROM ExamQuestions as eq 
        INNER JOIN Exams AS e ON eq.examID=e.examID
        INNER JOIN Questions AS q ON eq.questionID=q.questionID
        WHERE e.examID='{$examID}'"; 
    $result = mysqli_query($connection, $query);

    $exams = array();

    while ($row = mysqli_fetch_array($result)) {
        $exam = array('questionID' => $row['questionID'], 'question' => $row['question'], 'questionPoints' => $row['questionPoints']); 
        array_push($exams, $exam);
    }
    $response = json_encode($exams);
    echo $response;

    $connection->close();
 ?>