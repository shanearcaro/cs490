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

    // Read posted user data from the front end
    $user_data = json_decode(file_get_contents('php://input'));
    
    // Data received is already json encoded
    // Instead of decoding to just encode just send encoded data
    $question = $user_data->{'question'};
    $testcase1 = $user_data->{'testcase1'};
    $testcase2 = $user_data->{'testcase2'};
    
    //Insert question data into question table
    $query = "INSERT INTO Questions (question, testcase1, testcase2) VALUES ('{$question}', '{$testcase1}', '{$testcase2}')"; 

    $result = mysqli_query($connection, $query);

    $response = $result ? "Success" : "Failure";

    $response = json_encode($response);
    echo $response;

    $connection->close();
 ?>