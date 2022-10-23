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

    $user_data = json_decode(file_get_contents('php://input'));
    $answers = $user_data;

    // Get the accountID and the examID
    $accountID = array_pop($answers);
    $examID = array_pop($answers);

    // We have the accountID but to create an exam we need the studentID
    $query = "SELECT studentID FROM Students WHERE accountID='{$accountID}'";
    $result = mysqli_query($connection, $query);
    $row = mysqli_fetch_array($result);
    $studentID = $row['studentID'];

    // We have the accountID but to create an exam we need the teacherID
    $query = "SELECT studentExamID FROM StudentExams WHERE studentID='{$studentID}' AND examID='{$examID}'";
    $result = mysqli_query($connection, $query);
    $row = mysqli_fetch_array($result);
    $studentExamID = $row['studentExamID'];

    // Get all the questionIDs for the current exam
    $query = "SELECT questionID FROM ExamQuestions WHERE examID='{$examID}'";
    $result = mysqli_query($connection, $query);
    $response = $result;

    $response = json_encode($response);
    echo $response;

    $connection->close();
 ?>