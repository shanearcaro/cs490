<?php
    $questionBank = array();
    for ($i = 0; $i < count($_POST['checkBox']); $i++) {
        $questionBank[$_POST['checkBox'][$i]] = $_POST['points'][$i];
    }

    foreach($questionBank as $key=>$value) {
        echo $key . "=" . $value . " ";
    }

    // Encode the data into JSON format
    $encoded = json_encode($questionBank);

    // Connection for the middle end
    $url = 'localhost/src/middle/validateExam.php';

    // Initialized a cURL session
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $encoded);

    // Decode the results of sending the data
    $result = curl_exec($ch);
    $result = json_decode($result);
    curl_close($ch);

    echo "[ " . $result . " ]";

    // Contacting the back end will return Student, Teacher, or Bad Login.
    // Update the current page depending on the result from the database.
    // if ($result == "Student") {
    //     header("Location: ../student.php");
    // }
    // else if ($result == "Teacher") {
    //     echo "<script>;window.location.href='/src/frontend/TeacherPages/teacher.php';</script>";
    // }
    // else {
    //     echo "<script>alert('Invalid Credentials');window.location.href='/';</script>";
    // }

    /**
     * Right now we have two post arrays, $_POST['checkBox'] and $_POST['points].
     * The code above combines both these arrays together in key, value pairs but I did this too early.
     * 
     * This information has to be sent to the middle and then to the back end because it can be put into a database
     */

    //  SELECT AUTO_INCREMEMNT FROM Exam;
?>