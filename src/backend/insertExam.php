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

    // Get max id from Exams table
    $query = "SELECT * FROM Exams WHERE examID=(SELECT max(examID) FROM Exams)";
    $result = mysqli_query($connection, $query);

    // Page variables
    $total = mysqli_num_rows($result);
    $numberOfQuestions = 0;
    $accountID = -1;
    $teacherID = -1;
    $questionList = array();
    $pointsList = array();

    // Calculate the exam id for the new entry
    $examID = -1;
    if ($total == 1) {
        while ($row = mysqli_fetch_array($result)) {
            $maxID = $row['examID'];
        }
        $examID = $maxID + 1;
    }
    else
        $examID = 1;

    // Read posted user data from the front end
    $user_data = json_decode(file_get_contents('php://input'));

    // Separate data into two different arrays, one for questions and one for points
    foreach($user_data as $key => $value) {
        array_push($questionList, $key);
        array_push($pointsList, $value);
    }
    // Calculate number of questions and account id from input data
    $numberOfQuestions = count($questionList) - 1;
    $accountID = $pointsList[$numberOfQuestions];

    // We have the accountID but to create an exam we need the teacherID
    $query = "SELECT teacherID FROM Teachers WHERE accountID='{$accountID}'";
    $result = mysqli_query($connection, $query);
    while ($row = mysqli_fetch_array($result)) {
        $teacherID = $row['teacherID'];
    }

    // The last element in questionList is just a regular array index not a questionID
    // The corresponding element in pointsList is the accountID for the currently signed in user
    // These elements need to be popped from the ends of the arrays
    array_pop($questionList);
    array_pop($pointsList);

    $response = "Working" . $teacherID;
    $totalPointValue = array_sum($pointsList);

    // No questions were selected when creating an exam
    if ($numberOfQuestions == 0) {
        $response = "Empty";
    }
    else {
        /**
         * numberOfQuestions is the correct size, the problem is that the size of keys
         * is always one which is causing an ArrayOutOfBounds exception.
         * 
         * Have to figure out why array_keys is returning an array of size 1, or find
         * out how to get the keys of the array with a different method.
         */
        // $accountID = array_key_last($usable_data);
        // $keys = array_keys($usable_data);
        // $response = count($keys) . " " . count($usable_data);
        // for ($i = 0; $i < $numberOfQuestions; $i++) {
            // $questionID = $keys[$i];
            // $pointValue = $usable_data[$keys[$i]];
            // $response = $pointValue;
            // $response .= "S";
            // $totalPointvalue += $pointValue;
        }
        $query = "INSERT INTO Exams (examID, examPoints, numberOfQuestions, teacherID) VALUES ('{$examID}', '{$totalPointValue}', '{$numberOfQuestions}', '{$teacherID}')";
        mysqli_query($connection, $query);
        // for ($i = 0; $i < $numberOfQuestions; $i++) {
        //     $questionID = $questionList[$i];
        //     $pointValue = $pointsList[$i];
        //     $totalPointValue += $pointValue;
        //     $query = "INSERT INTO ExamQuestions (examID, questionID, questionPoints) VALUES ('{$examID}', '{$questionID}', '{$pointValue}')";
        //     mysqli_query($connection, $query);
        // }
        // $response = $usable_data[0];
        // $query = "INSERT INTO Exams (examID, examPoints, numberOfQuestions, teacherID) VALUES ('{$examID}', '{$totalPointValue}', '{$numberOfQuestions}', '{$accountID}')";
        // mysqli_query($connection, $query);

    //     for ($i = 0; $i < $numberOfQuestions; $i++) {
    //         $questionID = $keys[$i];
    //         $pointValue = $user_data[$keys[$i]];
    //         $query = "INSERT INTO ExamQuestions (examID, questionID, questionPoints) VALUES ('{$examID}', '{$questionID}', '{$pointValue}')";
    //         mysqli_query($connection, $query);
    //     }
    //     $response = $numberOfQuestions . " number of questions created";
    // }

    $connection->close();
    

    // $connection = new mysqli($_ENV['HOST'], $_ENV['NAME'], $_ENV['PASS'], $_ENV['DATABASE']);

    // // Prompt error if database connection doesn't work and exit the script
    // if ($connection->connect_error) {
	//     echo "Failed to connect to MYSQL: " . mysqli_connect_error();
    //     exit();
    // }

    // $query = "SELECT * FROM Exams WHERE examID=(SELECT max(examID) FROM Exams)";
    // $result = mysqli_query($connection, $query);

    // $total = mysqli_num_rows($result);

    // $examID = -1;
    // if ($total == 1) {
    //     while ($row = mysqli_fetch_array($result)) {
    //         $maxID = $row['id'];
    //     }
    //     $examID = $maxID + 1;
    // }
    // else
    //     $examID = 1;

    // // Read posted user data from the front end
    // $user_data = json_decode(file_get_contents('php://input'));
    
    $response = json_encode($response);
    echo $response;

    /**
     * Need a way to get the ID of the user that is currently logged in
     * The UserAccounts table also should be changed to include a teacher
     * and a students table to that students aren't able to create exams
     */

    // $connection->close();
 ?>