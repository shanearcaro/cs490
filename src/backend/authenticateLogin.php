<?php
    session_start();

    $db_credentials = include 'credentials.php';

    $connection = new mysqli($db_credentials['HOST'], $db_credentials['NAME'], $db_credentials['PASS'], $db_credentials['DATABASE']);

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
    $query = "SELECT * FROM Users WHERE username='{$username}' AND password='{$password}' LIMIT 1";
    $result = mysqli_query($connection, $query);

    // // Extract the username is isTeacher from the query results
    $accountID = -1;
    $get_teacher = 0;

    while ($row = mysqli_fetch_array($result)) {
	   $accountID = $row['accountID'];
    }

    $query = "SELECT username FROM Users INNER JOIN Teachers ON Users.accountID=Teachers.accountID WHERE Users.accountID='{$accountID}'";
    $result = mysqli_query($connection, $query);

    $total = mysqli_num_rows($result);

    if ($total == 1)
        $get_teacher = 1;

    $accountType;

    if ($accountID == -1) {
	    $response = "Bad Login";
    }
    else {
	    if ($get_teacher == 0)
            $accountType = "Student";
	    else
            $accountType = "Teacher";
    }

    $response = array("type" => $accountType, "accountID" => $accountID);

    $response = json_encode($response);
    echo $response;

    $connection->close();
 ?>