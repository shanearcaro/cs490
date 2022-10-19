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
    $username = $user_data->{'username'};
    $password = $user_data->{'password'};
    
    // Extract user info given username and password
    $query = "SELECT * FROM UserAccounts WHERE username='{$username}' AND password='{$password}' LIMIT 1";
    $result = mysqli_query($connection, $query);

    // Extract the username is isTeacher from the query results
    $get_username = '';
    $get_teacher  = 0;

    while ($row = mysqli_fetch_array($result)) {
	   $get_username = $row['username'];
	   $get_teacher = $row['isTeacher'];
       $_SESSION['user'] = $row['accountID'];
    }

    $response = "";

    if ($get_username == '') {
	    $response = "Bad Login";
    }
    else {
	    if ($get_teacher == 0)
            $response = "Student";
	    else
            $response = "Teacher";
    }
    $response = json_encode($response);
    echo $response;

    $connection->close();
 ?>