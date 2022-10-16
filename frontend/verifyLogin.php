<?php
    // Get username and password from Malcolm's login screen.
    $username = $_POST['username'];
    $password = $_POST['password'];

    $data = array('username' => $username, 'password' => $password);

    // Encode the data into JSON format
    $encoded = json_encode($data);
    // print_r($encoded);

    $url = 'https://afsaccess4.njit.edu/~sma237/CS490/middle/validate.php';

    // Initialized a cURL session
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $encoded);

    // header('Location: ../backend/query.php');

   $result = json_decode(curl_exec($ch));
   curl_close($ch);

   if (strpos($result, "Student")) {
	   header("Location: https://afsaccess4.njit.edu/~mcs43/cs490/frontend/StudentPages/student.php");
	   exit();
   }
   else if (strpos($result, "Teacher")) {
	   header("Location: https://afsaccess4.njit.edu/~mcs43/cs490/frontend/TeacherPages/teacher.php");
	   exit();
   }
   else {
	   header("Location: https://afsaccess4.njit.edu/~mcs43/cs490/frontend/login.php");
	   exit();
   }

?>
