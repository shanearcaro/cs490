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

    $query = "SELECT * FROM Exams WHERE id=(SELECT max(id) FROM Exams)";
    $result = mysqli_query($connection, $query);

    $total = mysqli_num_rows($result);

    $examID = -1;
    if ($total == 1) {
        while ($row = mysqli_fetch_array($result)) {
            $maxID = $row['id'];
        }
        $examID = $maxID + 1;
    }
    else
        $examID = 1;

    // Read posted user data from the front end
    $user_data = json_decode(file_get_contents('php://input'));
    
    $response = "Connecting to database";
    $response = json_encode($examID);
    echo $response;

    /**
     * Need a way to get the ID of the user that is currently logged in
     * The UserAccounts table also should be changed to include a teacher
     * and a students table to that students aren't able to create exams
     */

    $connection->close();
 ?>