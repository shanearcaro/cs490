<?php
    session_start();

    // Log the user out if the session isn't valid anymore.
    // This can happen because of a refresh or if the url is typed manually and the user doesn't log in.
    if (!isset($_SESSION['accountID'])) {
        echo "<script>alert('Session invalid, logging out.');</script>";
        echo "<script>window.location.href='/';</script>";
        exit();
    }
    $name = array();
    array_push($name, $_SESSION['accountID']);

    $backend_url = 'https://afsaccess4.njit.edu/~mcs43/src/backend/selectName.php';
    array_push($name, $backend_url);

    // // Encode the data into JSON format
    $encoded = json_encode($name);

    // Connection for the middle end
    $url = 'https://afsaccess4.njit.edu/~mcs43/src/middle/middle.php';

    // Initialized a cURL session
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $encoded);

    // Decode the results of sending the data
    $result = curl_exec($ch);
    $username = json_decode($result);
    echo "<h1>Welcome " . $username . "! What would you like to do?</h1>";
    curl_close($ch);
?>
<!DOCTYPE html>
<HTML lang ="en">
    <head>
        <Title>Teacher Portal</Title>
    </head>
    <link rel="Stylesheet" href="../../../style/default.css?<?php echo time();?>"/>
    <body>
        <div class="teacherLanding">
            <!--Move to question creation page -->
            <form action="./questionBank.php" target="_self">
                <input type="submit" name="b1" value="Create Questions">
            </form>
            <!--Move to the exam creation page -->
            <form action="./createExam.php" target="_self">
                <input type="submit" name="b2" value="Create Exam">
            </form>
            <!-- Move to the review exam page --> 
            <form action="./gradeExam.php" target="_self">
                <input type="submit" name="b3" value="Grade Exams">
            </form>
        </div>
    </body>
</HTML>
