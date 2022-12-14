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
    <link rel="Stylesheet" href="../../../style/studentExam.css?<?php echo time();?>"/>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Comfortaa:wght@300;400;500;600;700&display=swap" rel="stylesheet"> <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=PT+Sans+Narrow:wght@400;700&display=swap" rel="stylesheet"> 
</head>
<body>
    
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

    $backend_url = 'localhost/src/backend/selectExamQuestions.php';
    array_push($exam, $backend_url);

    // // Encode the data into JSON format
    $encoded = json_encode($exam);

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

    echo '<div class="questionBank">';
    echo '<h1 id="title">Exam</h1>';
    echo '<div class="questionTable">';
    echo '<div class="tableLabels">';
    echo '<ul>';
    echo '<li class="labels">Question</li>';
    echo '<li class="labels">Point Value</li>';
    echo '<li class="labels">Answer</li>';
    echo '</ul>';
    echo '</div>';
    echo '<div class="questionRows">';
    echo "EXAM ID: " . $_SESSION['examID'];
    echo '<form name="createExam" method="post" id="examForm" action="../post/sendCompletedExam.php">';
    for ($i = 0; $i < count($examQuestions); $i++) {
        $question = $examQuestions[$i];
        $questionText = $question->{'question'};
        $pointValue = $question->{'questionPoints'};
        $questionID = $question->{'questionID'};
        echo '<div class="row">';
        echo '<ul>';
        echo '<li class="element">' . nl2br($questionText) . '</li>';
        echo '<li class="element">' . $pointValue . '</li>';
        echo '<li class="element"><textarea form="examForm" class="element-text" name="answer[]" required></textarea>';
        echo '</ul>';
        echo '</div>';
    }
    echo '<input class="button" type="submit" name="submit" value="Submit">';
    echo '</form>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
?>