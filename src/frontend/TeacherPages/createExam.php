<?php
    session_start();

    // Log the user out if the session isn't valid anymore.
    // This can happen because of a refresh or if the url is typed manually and the user doesn't log in.
    if (!isset($_SESSION['accountID'])) {
        echo "<script>alert('Session invalid, logging out.');</script>";
        echo "<script>window.location.href='/';</script>";
        exit();
        
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Exam</title>
<<<<<<< HEAD
    <link rel="Stylesheet" href="../../../style/tableDisplay.css?<?php echo time();?>"/>
=======
    <link rel="Stylesheet" href="../../../style/TeacherPages/createExam.css?<?php echo time();?>"/>
>>>>>>> feature/css-update
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Comfortaa:wght@300;400;500;600;700&display=swap" rel="stylesheet"> <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=PT+Sans+Narrow:wght@400;700&display=swap" rel="stylesheet"> 
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
</body> 
</body>
</html>

<?php
    // Send the accountID with the request
    $data = array('accountID' => $_SESSION['accountID']);
    $backend_url = 'https://afsaccess4.njit.edu/~mcs43/src/backend/selectQuestions.php';
    array_push($data, $backend_url);
    // Encode the data into JSON format
    $encoded = json_encode($data);

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
    $questions = json_decode($result);
    curl_close($ch);

        // Render all exams on the screen
        echo '
        <div class="right">
            <div class="examBank">
                <div class="examHeader">';
                    if ($questions == "Empty") 
                        echo '
                            <h2 id="examsTitle">No exams available</h2>
                            <div class="examButtons2">
                                <input id="backButton2" form="backButtonForm" type="submit" name="submit" value="Back">
                                <form action="http://localhost:8000/src/frontend/TeacherPages/teacher.php" id="backButtonForm"></form>
                            </div>
                    ';
                    else {
                        echo '
                            <h2 id="examsTitle">Create Exam</h2>
                            <div class="labels">
                                <ul>
                                    <li id="teacherName">Question</li>
                                    <li id="examID">Test Case 1</li>
                                    <li id="points">Test Case 2</li>
                                    <li id="questions">Points</li>
                                </ul>
                            </div>
                            <div class="examRows">
                                <form name="createExam" id="pickExam" method="POST" action="../post/sendExam.php">';
                                    // Loop  through all available exams 
                                    for ($i = 0; $i < count($questions); $i++) {
                                            $question = $questions[$i];
                                            // Get all variables needed for display
                                            $question       = $questions[$i];
                                            $questionID     = $question->{'questionID'};
                                            $questionText   = $question->{'question'};
                                            $testcase1      = $question->{'testcase1'};
                                            $testcase2      = $question->{'testcase2'};

                                            echo '
                                                <div class="examRow">
                                                    <div class="checkBoxElement listElement"><input type="checkbox" required class="checkBox" name="checkBox[]" value="'. $questionID .'"></div>
                                                    <div class="teacherNameElement listElement"<p>' . nl2br($questionText) . '</p></div>
                                                    <div class="examIDElement listElement"<p>' . $testcase1 . '</p></div>
                                                    <div class="pointsElement listElement"<p>' . $testcase2 . '</p></div>
                                                    <div class="pointsElement listElement"><input type="number" form="pickExam" class="element-text" name="points[]" value="0" min="0" required pattern="[0-9]"></div>
                                                </div>
                                            ';
                                    }
                                echo '                      
                                <div class="examButtons">
                                    <input id="submitButton" form="pickExam" type="submit" name="submit" value="Select">
                                    <input id="backButton" form="backButtonForm" type="submit" name="submit" value="Back">
                                </div>
                                </form>
                                <form action="http://localhost:8000/src/frontend/TeacherPages/teacher.php" id="backButtonForm"></form>
                            </div>
                        ';
                    }
                echo ' 
                </div>
            </div>
        </div>
    ';
?>