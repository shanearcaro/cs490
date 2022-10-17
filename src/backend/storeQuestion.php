<?php
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

    // Read posted question data from the front end
    $questionData = json_decode(file_get_contents('php://input'));

    $question = (string)$questionData -> {'question'};
    $testCase1 = (string)$questionData -> {'testCase1'};
    $testCase2 = (string)$questionData -> {'testCase2'};

    //Insert question data into question table
    $query = "INSERT INTO Questions (QUESTION, TESTCASE1, TESTCASE2) 
              VALUES ('$question', '$testCase1', '$testCase2')";

    mysqli_query($connection, $query);

    $connection -> close();
?>