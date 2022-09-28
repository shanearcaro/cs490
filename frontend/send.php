<?php
    // Get username and password from Malcolm's login screen and create a data array
    $username = $_POST['username'];
    $password = $_POST['password'];

    $data = array('username' => $username, 'password' => $password);

    // Encode the data into JSON format
    $encoded = json_encode($data);

    // Connection for the middle end
    $url = 'https://afsaccess4.njit.edu/~sma237/CS490/middle/validate.php';

    // Initialized a cURL session
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $encoded);

    // Decode the results of sending the data
   $result = json_decode(curl_exec($ch));
   curl_close($ch);

   // Contacting the back end will return Student, Teacher, or Bad Login.
   // Update the current page depending on the result from the database.
   if (strpos($result, "Student")) {
	   header("Location: https://afsaccess4.njit.edu/~mcs43/cs490/frontend/student.php");
	   exit();
   }
   else if (strpos($result, "Teacher")) {
	   header("Location: https://afsaccess4.njit.edu/~mcs43/cs490/frontend/teacher.php");
	   exit();
   }
   else {
	   header("Location: https://afsaccess4.njit.edu/~mcs43/cs490/frontend/login.php");
	   exit();
   }

?>
