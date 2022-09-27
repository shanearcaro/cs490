<?php
    include("credentials.php");
    $connection = mysqli_connect($server, $username, $password, $database);
    $user_data = file_get_contents('php://input');

    $data = json_decode($user_data);
    $username = $data->{'username'};
    $password = $data->{'password'};

    if (mysqli_connect_error())
	    echo "Failed to connect to MYSQL: " . mysql_connect_error();
	
    $query = "SELECT * FROM UserAccounts WHERE username='{$username}' AND password='{$password}' LIMIT 1";
    $result = mysqli_query($connection, $query);

    $get_username = '';
    $get_teacher  = 0;

    while ($row = mysqli_fetch_array($result)) {
	   $get_username = $row['username'];
	   $get_teacher = $row['isTeacher'];
    }

    if ($get_username == '') {
	    echo json_encode("Bad login");
    }
    else {
	    if ($get_teacher == 0)
		    echo json_encode("Student");
	    else
		    echo json_encode("Teacher");
    }

    mysqli_close($connection);
 ?>
