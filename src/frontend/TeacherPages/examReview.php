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
    <title>Exam</title>
    <link rel="Stylesheet" href="../../../style/TeacherPages/examReview.css?<?php echo time();?>"/>
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
</html>

<?php
    // Send the accountID with the request
    $data = array('accountID' => $_SESSION['accountID']);

    $backend_url = 'localhost/src/backend/selectExamsTeacher.php';
    array_push($data, $backend_url);
    $encoded = json_encode($data);

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
    $exams = json_decode($result);
    curl_close($ch);

    // Need to do this to get multiple values at once
    $index = $_POST['index'][0];
    $selectedExam = $exams[$index];
    $studentExamID = $selectedExam->{'studentExamID'};
    $selectedExam = json_encode($selectedExam);

    // Sending accountID, studentExamID, and the url to the backend
    $sendData = array();
    array_push($sendData, $_SESSION['accountID']);
    array_push($sendData, $studentExamID);

    // POTENTIAL BUG WITH STUDENT EXAM ID AND EXAM ID MIX UP IN THE AUTO GRADER AND RIGHT HERE

    $backend_url = 'localhost/src/backend/selectCompletedExam.php';
    array_push($sendData, $backend_url);

    // Encode the data into JSON format
    $encoded = json_encode($sendData);

    // Connection for the middle end
    $url = 'localhost/src/middle/autoGrader.php';

    // Initialized a cURL session
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $encoded);

    // Decode the results of sending the data
    $result = curl_exec($ch);
    $examQuestions = json_decode($result);
    curl_close($ch);

    // answer, case, points, newPoints, result, expected, quesitonID

        // Render all questions on the screen
        echo '
        <div class="right">
            <div class="examBank">
                <div class="examHeader">';
                    if ($examQuestions == "Empty") 
                        echo '
                        <h2 id="examsTitle">No exams available</h2>
                        <div class="examButtons2">
                            <input id="backButton2" form="backButtonForm" type="submit" name="submit" value="Back">
                        </div>
                        <form action="http://localhost:8000/src/frontend/TeacherPage/teacher.php" id="backButtonForm"></form>
                        ';
                    else {
                        echo '
                            <h2 id="examsTitle">Review Exams</h2>
                            <div class="labels">
                                <ul>
                                    <li id="teacherName">Question</li>
                                    <li id="examID">Answer</li>
                                    <li id="points">Grade</li>
                                    <li id="points">Points Possible</li>
                                    <li id="points">Testcase</li>
                                    <li id="points">Actual</li>
                                    <li id="points">Expected</li>
                                    <li id="points">Comments</li>
                                </ul>
                            </div>
                            <div class="examRows">
                                <form name="createExam" id="pickExam" method="POST" action="../post/sendGrade.php">';
                                    // Loop  through all available exams 
                                    for ($i = 0; $i < count($examQuestions); $i+=2) {
                                            // Get all variables needed for display
                                            $row            = $examQuestions[$i];
                                            $result1        = $row->{'result'};
                                            $expected       = $row->{'expected'};
                                            $score          = $row->{'newPoints'};
                                            $testcase1      = $row->{'case'};
                                    
                                            $row2           = $examQuestions[$i + 1];
                                            $score2         = $row2->{'newPoints'};
                                            $result2        = $row2->{'result'};
                                            $expected2      = $row2->{'expected'};
                                            $testcase2      = $row2->{'case'};
                                    
                                            $question       = $row->{'question'};
                                            $answer         = $row->{'answer'};
                                            $pointValue     = $row->{'points'};
                                            $questionID     = $row->{'questionID'};
                                            $score          = (int) $score;

                                            echo '
                                                <div class="examRow">
                                                <div class="teacherNameElement listElement"><p>' . $question . '</p></div>
                                                <div class="examIDElement listElement"><p>' . $answer . '</p></div>
                                                <div class="examIDElement listElement"><input type=number class="element-text" id="gradeReview" name="score[]" value="' . $score . '" required min=0 max="' . $pointValue . '"></div>
                                                <div class="teacherNameElement listElement"><p>' . $pointValue . '</p></div>
                                                <div class="teacherNameElement listElement"><p>' . $testcase1 . '</p></div>
                                                <div class="teacherNameElement listElement"><p>' . $result1 . '</p></div>
                                                <div class="teacherNameElement listElement"><p>' . $expected . '</p></div>
                                                <input type=hidden class="element-text" name="questionID[]" value="' . $questionID . '">
                                                <input type=hidden class="element-text" name="studentExamID" value="' . $studentExamID . '">
                                                <input type=hidden class="element-text" name="result1[]" value="' . $result1 . '">
                                                <input type=hidden class="element-text" name="result2[]" value="' . $result2 . '">
                                                <div class="element"><input type=text class="element-text" name="comment[]" id="commentReview"placeholder=""></div>
                                                </div>

                                                <div class="examRow">
                                                    <div class="fillerElement"></div>
                                                    <div class="teacherNameElement listElement">' . $testcase2 . '</div>
                                                    <div class="teacherNameElement listElement">' . $result2 . '</div>
                                                    <div class="teacherNameElement listElement"><p>' . $expected2 . '</p></div>
                                                    <input type=hidden class="element-text" name="studentExamID" value="' . $studentExamID . '">
                                                </div>
                                            ';
                                    }
                                echo '                      
                                <div class="examButtons">
                                    <input id="submitButton" form="pickExam" type="submit" name="submit" value="Select">
                                    <input id="backButton" form="backButtonForm" type="submit" name="submit" value="Back">
                                </div>
                                </form>
                                <form action="http://localhost:8000/src/frontend/TeacherPage/teacher.php" id="backButtonForm"></form>
                            </div>
                        ';
                    }
                echo ' 
                </div>
            </div>
        </div>
    ';

    // echo '<div class="questionBank">';
    // echo '<h1 id="title">Exam</h1>';
    // echo '<div class="questionTable">';
    // echo '<div class="tableLabels">';
    // echo '<ul>';
    // echo '<li class="labels">Question</li>';
    // echo '<li class="labels">Answer</li>';
    // echo '<li class="labels">Grade</li>';
    // echo '<li class="labels">Points Possible</li>';
    // echo '<li class="labels">Testcase</li>';
    // echo '<li class="labels">Actual</li>';
    // echo '<li class="labels">Expected</li>';
    // echo '<li class="labels">Comments</li>';
    // echo '</ul>';
    // echo '</div>';
    // echo '<div class="questionRows">';
    // echo '<form name="createExam" method="post" id="examForm" action="../post/sendGrade.php">';
    // for ($i = 0; $i < count($examQuestions); $i+=2) {
    //     $row = $examQuestions[$i];
    //     $result1 = $row->{'result'};
    //     $expected = $row->{'expected'};
    //     $score = $row->{'newPoints'};
    //     $testcase1 = $row->{'case'};

    //     $row2 = $examQuestions[$i + 1];
    //     $score2 = $row2->{'newPoints'};
    //     $result2 = $row2->{'result'};
    //     $expected2 = $row2->{'expected'};
    //     $testcase2 = $row2->{'case'};

    //     $question = $row->{'question'};
    //     $answer = $row->{'answer'};
    //     $pointValue = $row->{'points'};
    //     $questionID = $row->{'questionID'};
    //     $score = (int) $score;

    //     echo '<div class="row">';
    //     echo '<ul>';
    //     echo '<li class="element">' . $question . '</li>';
    //     echo '<li class="element">' . $answer . '</li>';
    //     echo '<li class="element"><input type=number class="element-text" name="score[]" value="' . $score . '" required min=0 max="' . $pointValue . '"></li>';
    //     echo '<li class="element">' . $pointValue . '</li>';
    //     echo '<li class="element">' . $testcase1 . '</li>';
    //     echo '<li class="element">' . $result1 . '</li>';
    //     echo '<li class="element">' . $expected . '</li>';
    //     echo '<input type=hidden class="element-text" name="questionID[]" value="' . $questionID . '">';
    //     echo '<input type=hidden class="element-text" name="studentExamID" value="' . $studentExamID . '">';
    //     echo '<input type=hidden class="element-text" name="result1[]" value="' . $result1 . '">';
    //     echo '<input type=hidden class="element-text" name="result2[]" value="' . $result2 . '">';
    //     echo '<li class="element"><input type=text class="element-text" name="comment[]" placeholder="Comment"></li>';
    //     echo '</ul>';
    //     echo '</div>';

    //     echo '<div class="row">';
    //     echo '<ul>';
    //     echo '<li class="element"></li>';
    //     echo '<li class="element"></li>';
    //     echo '<li class="element"></li>';
    //     echo '<li class="element"></li>';
    //     echo '<li class="element">' . $testcase2 . '</li>';
    //     echo '<li class="element">' . $result2 . '</li>';
    //     echo '<li class="element">' . $expected2 . '</li>';
    //     echo '<input type=hidden class="element-text" name="studentExamID" value="' . $studentExamID . '">';
    //     echo '<li class="element"></li>';
    //     echo '</ul>';
    //     echo '</div>';
    // }
    // echo '<input class="button" type="submit" name="submit" value="Submit">';
    // echo '</form>';
    // echo '</div>';
    // echo '</div>';
    // echo '</div>';
?>