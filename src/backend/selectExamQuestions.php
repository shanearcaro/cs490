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
    $examID = $user_data[0];
    $studentID = $user_data[1];

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

    /**
     * Students can not retrieve exam questions for the exam they are trying to take
     * 
     * Need to push all the changes:
     *  1. The style folder changes
     *  2. The random extra folder merge deletions
     *  3. The acutal changes
     */
 ?>