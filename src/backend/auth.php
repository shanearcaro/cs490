<?php
    // Read from credentials file and connect to database
    $dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__, 2));
    $dotenv->load();

    $connection = mysqli_connect($_ENV['SERVER'], $_ENV['USERNAME'], $_ENV['PASSWORD'], $_ENV['DATABASE']);

    // Prompt error if database connection doesn't work and exit the script
    if (mysqli_connect_error()) {
	    echo "Failed to connect to MYSQL: " . mysqli_connect_error();
        exit();
    }

    // Read posted user data from the middle
    $user_data = file_get_contents('php://input');

    // Extract username and password
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
    }

    // If username is blank that means the query found no results, bad login.
    if ($get_username == '') {
	    echo json_encode("Bad login");
    }
    else {
        // Determine if the user account is a teacher or a student
	    if ($get_teacher == 0)
		    echo json_encode("Student");
	    else
		    echo json_encode("Teacher");
    }

    mysqli_close($connection);
 ?>
