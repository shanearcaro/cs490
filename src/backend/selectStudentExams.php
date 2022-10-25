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

    // We have the accountID but to view graded exams we need the studentID
    $query = "SELECT studentID FROM Students WHERE accountID='{$accountID}'";
    $result = mysqli_query($connection, $query);
    $row = mysqli_fetch_array($result);
    $studentID = $row['studentID'];

    // Query to pull all exams that are graded and linked to this student
    $query = "SELECT se.studentExamID, u.username, se.studentID, se.examID, se.score, e.examPoints FROM StudentExams AS se
                INNER JOIN Exams AS e on se.examID=e.examID
                INNER JOIN Students AS s ON se.studentID=s.studentID
                INNER JOIN Users AS u on s.accountID=u.accountID
                WHERE se.score!=-1 AND se.studentID='{$studentID}'";
    
    $result = mysqli_query($connection, $query);

    $exams = array();

    while ($row = mysqli_fetch_array($result)) {
        $exam = array(
            'studentExamID' => $row['studentExamID'], 
            'studentID'     => $row['studentID'], 
            'examID'        => $row['examID'], 
            'score'         => $row['score'], 
            'examPoints'    => $row['examPoints'],
            'username'      => $row['username']);
        array_push($exams, $exam);
    }

    $response = count($exams) == 0 ? "Empty" : $exams;
    $response = json_encode($response);
    echo $response;

    $connection->close();
?>