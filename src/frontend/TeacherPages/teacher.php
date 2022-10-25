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

    $backend_url = 'localhost/src/backend/selectName.php';
    array_push($name, $backend_url);

    // // Encode the data into JSON format
    $encoded = json_encode($name);

    // Connection for the middle end
    $url = 'localhost/src/middle/middle.php';

    // Initialized a cURL session
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $encoded);

    // Decode the results of sending the data
    $result = curl_exec($ch);
    $username = json_decode($result);
    curl_close($ch);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Hub</title>
    <link rel="Stylesheet" href="./../../../style/TeacherPages/teacher.css?<?php echo time();?>"/>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="left">
            <div class="header">
                <h2 id="title">CS 490</h2>
                <h3 id="semester">Fall 2022</h3>
                <img src="../../../assets/njit.png" alt="NJIT LOGO">
                <h4>Shane Arcaro, Malcolm Shuler, Ege Atay</h4>
            </div>
    </div>
    <div class="right">
        <div class="teacherLanding">
            <?php  echo "<h2>Welcome " . ucfirst($username) . "!</h2>"; ?>
            <div class="form-buttons">
                <form action="./questionBank.php" target="_self">
                    <input type="submit" id="createQuestion" class="buttons" name="b1" value="Create Questions">
                </form>
                <!--Move to the exam creation page -->
                <form action="./createExam.php" target="_self">
                    <input type="submit" id="createExam" class="buttons" name="b2" value="Create Exam">
                </form>
                <!-- Move to the review exam page --> 
                <form action="./gradeExam.php" target="_self">
                    <input type="submit" id="gradeExam" class="buttons" name="b3" value="Grade Exams">
                </form>
            </div>
        </div>
    </div>
</body>
</html>