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
    <link rel="Stylesheet" href="../../../style/StudentPages/exam.css?<?php echo time();?>"/>
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
    $exam = array();
    if (isset($_POST['checkBox'])) {
        for ($i = 0; $i < count($_POST['checkBox']); $i++) {
            array_push($exam, $_POST['checkBox'][$i]);
        }
    }
    array_push($exam, $_SESSION['accountID']);
    $_SESSION['examID'] = $exam[0];

    $backend_url = 'https://afsaccess4.njit.edu/~mcs43/src/backend/selectExamQuestions.php';
    array_push($exam, $backend_url);

    // // Encode the data into JSON format
    $encoded = json_encode($exam);

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
    $examQuestions = json_decode($result);
    curl_close($ch);

    // Render all questions on the screen
    echo '
        <div class="right">
            <div class="examBank">
                <div class="examHeader">';
                        echo '
                            <h2 id="examsTitle">Exam</h2>
                            <div class="labels">
                                <ul>
                                    <li id="question">Question</li>
                                    <li id="points">Points</li>
                                    <li id="answer">Answer</li>
                                </ul>
                            </div>
                            <div class="examRows">
                                <form name="createExam" id="pickExam" method="POST" action="../post/sendCompletedExam.php">';
                                    // Loop  through all available exams 
                                    for ($i = 0; $i < count($examQuestions); $i++) {
                                            $examQuestion = $examQuestions[$i];
                                            // Get all variables needed for display
                                            $question       = $examQuestions[$i];
                                            $questionText   = $question->{'question'};
                                            $pointValue     = $question->{'questionPoints'};
                                            $questionID     = $question->{'questionID'};

                                            echo '
                                                <div class="examRow">
                                                    <div class="questionElement listElement"<p>' . nl2br($questionText) . '</p></div>
                                                    <div class="pointsElement   listElement"<p>' . $pointValue . '</p></div>
                                                    <textarea form="pickExam" class="answerElement listElement" name="answer[]" required></textarea>
                                                </div>';
                                    };
                            echo '        
                                <div class="examButtons">
                                    <input id="submitButton" form="pickExam" type="submit" name="submit" value="Submit">
                                </div>
                                </form>
                            </div>
                        ';
                echo ' 
                </div>
            </div>
        </div>
    ';
?>