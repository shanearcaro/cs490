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
    <link rel="Stylesheet" href="../../../style/examReview.css?<?php echo time();?>"/>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Comfortaa:wght@300;400;500;600;700&display=swap" rel="stylesheet"> <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=PT+Sans+Narrow:wght@400;700&display=swap" rel="stylesheet"> 
</head>
<body>
    
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

    // echo "[ " . $result . " ]";

    // questionID, question, answer, result1, result2, score, studentGrade, 
    // comment, points, testcase1, caseAnswer1, testcase2, caseAnswer2,examPoints

    echo '<div class="questionBank">';
    echo '<h1 id="title">Exam</h1>';
    echo '<div class="questionTable">';
    echo '<div class="tableLabels">';
    echo '<ul>';
    echo '<li class="labels">Points</li>';
    echo '<li class="labels">Question</li>';
    echo '<li class="labels">Answer</li>';
    echo '<li class="labels">Test Case</li>';
    echo '<li class="labels">Correct Answer</li>';
    echo '<li class="labels">Your Answer</li>';
    echo '<li class="labels">Teacher Comments</li>';
    echo '</ul>';
    echo '</div>';
    echo '<div class="questionRows">';
    echo '<div class="row">';
    echo '<ul>';
    echo '<li class="element">EXAM GRADE: ' . $examQuestions[0]->{'studentGrade'} . " out of " . $examQuestions[0]->{'examPoints'} . '</li>';
    echo '</ul>';
    echo '</div>';
    for ($i = 0; $i < count($examQuestions); $i++) {
        $row = $examQuestions[$i];
        $question = $row->{'question'};
        $answer = $row->{'answer'};
        $result1 = $row->{'result1'};
        $result2 = $row->{'result2'};
        $score = $row->{'score'};
        $comment = $row->{'comment'};
        $points = $row->{'points'};
        $testcase1 = $row->{'testcase1'};
        $caseAnswer1 = $row->{'caseAnswer1'};
        $testcase2 = $row->{'testcase2'};
        $caseAnswer2 = $row->{'caseAnswer2'};

        echo '<div class="row">';
        echo '<ul>';
        echo '<li class="element">' . $score . " out of " . $points . '</li>';
        echo '<li class="element">' . $question . '</li>';
        echo '<li class="element">' . $answer . '</li>';
        echo '<li class="element">' . $testcase1 . '</li>';
        echo '<li class="element">' . $result1 . '</li>';
        echo '<li class="element">' . $caseAnswer1 . '</li>';
        echo '<li class="element"><input type=text class="element-text" disabled name="comment[]" value="' . $comment . '"></li>';
        echo '</ul>';
        echo '</div>';

        echo '<div class="row">';
        echo '<ul>';
        echo '<li class="element"></li>';
        echo '<li class="element"></li>';
        echo '<li class="element"></li>';
        echo '<li class="element">' . $testcase2 . '</li>';
        echo '<li class="element">' . $result2 . '</li>';
        echo '<li class="element">' . $caseAnswer2 . '</li>';
        echo '<li class="element"></li>';
        echo '</ul>';
        echo '</div>';
    }
    include 'studentBackButton.php';
    echo '</div>';
    echo '</div>';
    echo '</div>';
?>