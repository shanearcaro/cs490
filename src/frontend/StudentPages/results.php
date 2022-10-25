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
    <title>Exam Review</title>
    <link rel="Stylesheet" href="../../../style/examReview.css?<?php echo time();?>"/>
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
    $data = array('accountID' => $_SESSION['accountID'], 'examID'=>$_POST['examID']);

    $backend_url = 'localhost/src/backend/selectExamResults.php';
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
    $examQuestions = json_decode($result);
    curl_close($ch);

// Render all questions on the screen
echo '
<div class="right">
    <div class="examBank">
        <div class="examHeader">';
                echo '
                    <h2 id="examsTitle">Exam Review</h2>
                    <div class="labels">
                        <ul>
                        <li id="points">Points</li>
                        <li id="question">Question</li>
                        <li id="answer">Response</li>
                        <li id="testcase">Test Case</li>
                        <li id="correctAnswer">Actual</li>
                        <li id="studentAnswer">Result</li>
                        <li id="teacherComment">Comments</li>
                        </ul>
                    </div>
                    <div class="examRows">
                        <form name="createExam" id="pickExam" method="POST" action="./results.php">';
                            // Loop  through all available exams 
                            for ($i = 0; $i < count($examQuestions); $i++) {
                                    $examQuestion = $examQuestions[$i];
                                    // Get all variables needed for display
                                    $row = $examQuestions[$i];
                                    $question       = $row->{'question'};
                                    $answer         = $row->{'answer'};
                                    $result1        = $row->{'result1'};
                                    $result2        = $row->{'result2'};
                                    $score          = $row->{'score'};
                                    $comment        = $row->{'comment'};
                                    $points         = $row->{'points'};
                                    $testcase1      = $row->{'testcase1'};
                                    $caseAnswer1    = $row->{'caseAnswer1'};
                                    $testcase2      = $row->{'testcase2'};
                                    $caseAnswer2    = $row->{'caseAnswer2'};

                                    echo '
                                        <div class="fullRow' . $i % 2 . '">
                                            <div class="examRow">
                                                <div class="scoreElement        listElement"<p>' . $score . "/" . $points . '</p></div>
                                                <div class="questionElement     listElement"<p>' . $question . '</p></div>
                                                <div class="answerElement       listElement"<p>' . nl2br($answer) . '</p></div>
                                                <div class="testcase1Element    listElement"<p>' . $testcase1 . '</p></div>
                                                <div class="caseAnswer1Element  listElement"<p>' . $caseAnswer1 . '</p></div>
                                                <div class="result1Element      listElement"<p>' . $result1 . '</p></div>
                                                <div class="commentElement      listElement"<p>' . $comment . '</p></div>
                                            </div>
                                            <div class="examRow">
                                                <div class="fillerElement       listElement"<p></p></div>
                                                <div class="testcase2Element    listElement"<p>' . $testcase2 . '</p></div>
                                                <div class="caseAnswer2Element  listElement"<p>' . $caseAnswer2 . '</p></div>
                                                <div class="result2Element      listElement"<p>' . $result2 . '</p></div>
                                            </div>
                                        </div>
                                    ';
                            }
                        echo '                      
                        <div class="examButtons">
                            <input id="submitButton" form="pickExam" type="submit" name="submit" value="Select">
                            <input id="backButton" form="backButtonForm" type="submit" name="submit" value="Back">
                        </div>
                        </form>
                        <form action="http://localhost:8000/src/frontend/StudentPages/student.php" id="backButtonForm"></form>
                    </div>
                ';
        echo ' 
        </div>
    </div>
</div>
';
?>