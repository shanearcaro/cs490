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
    $accountID = $user_data->{'accountID'};

    // We have the accountID but to create an exam we need the studentID
    $query = "SELECT studentID FROM Students WHERE accountID='{$accountID}'";
    $result = mysqli_query($connection, $query);
    while ($row = mysqli_fetch_array($result)) {
        $studentID = $row['studentID'];
    }

    $query = "SELECT e.examID, e.examPoints, e.numberOfQuestions, e.teacherID, u.username 
                FROM Exams as e 
                INNER JOIN Teachers AS t ON e.teacherID=t.teacherID
                INNER JOIN Users AS u ON t.accountID=u.accountID
                LEFT OUTER JOIN StudentExams AS se on e.examID=se.examID
                WHERE e.examID NOT IN (
                    SELECT examID FROM StudentExams
                    WHERE studentID='{$studentID}'
                );";
                
    $result = mysqli_query($connection, $query);

    $exams = array();

    while ($row = mysqli_fetch_array($result)) {
        $exam = array('examID' => $row['examID'], 'examPoints' => $row['examPoints'], 
        'numberOfQuestions' => $row['numberOfQuestions'], 'teacherID' => $row['teacherID'], 'username' => $row['username']);
        array_push($exams, $exam);
    }

    $response = json_encode($exams);
    echo $response;

    $connection->close();
 ?>